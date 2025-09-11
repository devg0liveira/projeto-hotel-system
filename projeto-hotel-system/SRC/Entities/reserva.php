<?php
namespace Hotel\Models;

use Hotel\Models\Abstract\{Quarto, Pessoa};
use Hotel\Services\ServicoInterface;
use Hotel\Utils\QuartoPersistence;
use Exception;

class Reserva
{
    private $quarto;
    private $hospedes = [];
    private $servicos = [];
    private $confirmada = false;
    private $data_reserva;
    private $id_reserva;

    public function __construct(Quarto $quarto)
    {
        if (!Quarto::temDisponibilidade($quarto->getTipo())) {
            throw new Exception("Não há quartos disponíveis do tipo: " . $quarto->getTipoNome());
        }

        $this->quarto = $quarto;
        $this->data_reserva = date('Y-m-d H:i:s');
        $this->id_reserva = $this->gerarIdReserva();
    }

    private function gerarIdReserva()
    {
        return 'RESERVA_' . date('Ymd') . '_' . substr(uniqid(), -6);
    }

    public function adicionarHospede(Pessoa $hospede)
    {
        $this->hospedes[] = $hospede;
        return $this;
    }

    public function adicionarServico(ServicoInterface $servico)
    {
        $this->servicos[] = $servico;
        return $this;
    }

    /**
     * ✅ CORREÇÃO: Lógica de cálculo ajustada
     * - Taxa PJ é aplicada apenas no quarto (20% adicional)  
     * - Serviços já retornam preço correto baseado no tipo de hóspede
     */
    public function calcularTotal(): float
    {
        $total = $this->quarto->getPreco();

        // Aplica taxa adicional de 20% no quarto se houver Pessoa Jurídica
        if ($this->temPessoaJuridica()) {
            $total *= 1.2;
        }

        // Adiciona valor dos serviços (que já aplicam taxa PJ internamente)
        foreach ($this->servicos as $servico) {
            foreach ($this->hospedes as $hospede) {
                $total += $servico->calcularPreco($hospede);
            }
        }

        return round($total, 2);
    }

    /**
     * ✅ Calcula apenas o valor dos serviços
     * (preços fixos para PF e PJ)
     */
    public function calcularTotalServicos(): float
    {
        $total_servicos = 0;

        foreach ($this->servicos as $servico) {
            foreach ($this->hospedes as $hospede) {
                $total_servicos += $servico->calcularPreco($hospede);
            }
        }

        return round($total_servicos, 2);
    }

    /**
     * ✅ Retorna o valor do quarto com taxa PJ aplicada se necessário
     */
    public function calcularTotalQuarto(): float
    {
        $total = $this->quarto->getPreco();
        
        if ($this->temPessoaJuridica()) {
            $total *= 1.2;
        }
        
        return round($total, 2);
    }

    public function confirmar()
    {
        if ($this->confirmada) {
            throw new Exception("Reserva já foi confirmada anteriormente");
        }

        if (empty($this->hospedes)) {
            throw new Exception("É necessário adicionar pelo menos um hóspede à reserva");
        }

        if (!$this->quarto->reservar()) {
            throw new Exception("Não foi possível reservar o quarto. Pode ter sido ocupado por outro cliente");
        }

        $this->confirmada = true;
        $this->salvarReserva();
        
        return true;
    }

    private function salvarReserva()
    {
        $dados_reserva = [
            'id' => $this->id_reserva,
            'data_reserva' => $this->data_reserva,
            'quarto' => [
                'numero' => $this->quarto->getNumero(),
                'tipo' => $this->quarto->getTipo(),
                'preco_base' => $this->quarto->getPreco(),
                'preco_final' => $this->calcularTotalQuarto(),
                'descricao' => $this->quarto->getDescricao()
            ],
            'hospedes' => [],
            'servicos' => [],
            'total_quarto' => $this->calcularTotalQuarto(),
            'total_servicos' => $this->calcularTotalServicos(),
            'total_geral' => $this->calcularTotal(),
            'tem_pessoa_juridica' => $this->temPessoaJuridica(),
            'confirmada' => $this->confirmada
        ];

        foreach ($this->hospedes as $hospede) {
            $dados_reserva['hospedes'][] = [
                'nome' => $hospede->getNome(),
                'email' => $hospede->getEmail(),
                'tipo' => $hospede->getTipo()
            ];
        }

        foreach ($this->servicos as $servico) {
            $dados_reserva['servicos'][] = [
                'descricao' => $servico->getDescricao(),
                'preco' => $servico->calcularPreco($this->hospedes[0] ?? null)
            ];
        }

        $arquivo_reservas = __DIR__ . '/../data/reservas.json';
        
        $dir = dirname($arquivo_reservas);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $reservas_existentes = [];
        if (file_exists($arquivo_reservas)) {
            $json_existente = file_get_contents($arquivo_reservas);
            $reservas_existentes = json_decode($json_existente, true) ?: [];
        }

        $reservas_existentes[] = $dados_reserva;
        file_put_contents($arquivo_reservas, json_encode($reservas_existentes, JSON_PRETTY_PRINT));
    }

    public function temPessoaJuridica(): bool
    {
        foreach ($this->hospedes as $hospede) {
            if ($hospede->getTipo() === "Juridica") {
                return true;
            }
        }
        return false;
    }

    // Getters...
    public function getQuarto(): Quarto { return $this->quarto; }
    public function getHospedes(): array { return $this->hospedes; }
    public function getServicos(): array { return $this->servicos; }
    public function isConfirmada(): bool { return $this->confirmada; }
    public function getId(): string { return $this->id_reserva; }
    public function getDataReserva(): string { return $this->data_reserva; }
}