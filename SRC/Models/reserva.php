<?php
namespace Hotel\Models;

use Hotel\Models\Abstract\{Quarto, Pessoa};
use Hotel\Services\ServicoInterface;
use Hotel\Utils\QuartoPersistence;
use Exception;

/**
 * Classe responsável por gerenciar reservas do hotel
 * Controla quartos, hóspedes, serviços e cálculos totais
 */
class Reserva
{
    private $quarto;
    private $hospedes = [];
    private $servicos = [];
    private $confirmada = false;
    private $data_reserva;
    private $id_reserva;

    /**
     * Construtor da reserva
     * Verifica disponibilidade do quarto antes de criar
     */
    public function __construct(Quarto $quarto)
    {
        // Verifica se o tipo de quarto tem disponibilidade
        if (!Quarto::temDisponibilidade($quarto->getTipo())) {
            throw new Exception("Não há quartos disponíveis do tipo: " . $quarto->getTipoNome());
        }

        $this->quarto = $quarto;
        $this->data_reserva = date('Y-m-d H:i:s');
        $this->id_reserva = $this->gerarIdReserva();
    }

    /**
     * Gera um ID único para a reserva
     */
    private function gerarIdReserva()
    {
        return 'RESERVA_' . date('Ymd') . '_' . substr(uniqid(), -6);
    }

    /**
     * Adiciona um hóspede à reserva
     */
    public function adicionarHospede(Pessoa $hospede)
    {
        $this->hospedes[] = $hospede;
        return $this;
    }

    /**
     * Adiciona um serviço à reserva
     */
    public function adicionarServico(ServicoInterface $servico)
    {
        $this->servicos[] = $servico;
        return $this;
    }

    /**
     * Calcula o valor total da reserva
     * Inclui: preço do quarto + taxa PJ (se aplicável) + serviços
     */
    public function calcularTotal(): float
    {
        $total = $this->quarto->getPreco();

        // Verifica se há Pessoa Jurídica entre os hóspedes
        $temPessoaJuridica = false;
        foreach ($this->hospedes as $hospede) {
            if ($hospede->getTipo() === "Juridica") {
                $temPessoaJuridica = true;
                break;
            }
        }

        // Aplica taxa adicional de 20% no quarto se for PJ
        if ($temPessoaJuridica) {
            $total *= 1.2;
        }

        // Adiciona valor dos serviços
        foreach ($this->servicos as $servico) {
            foreach ($this->hospedes as $hospede) {
                $total += $servico->calcularPreco($hospede);
            }
        }

        return round($total, 2);
    }

    /**
     * Calcula apenas o valor dos serviços
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
     * Confirma a reserva e aloca o quarto
     */
    public function confirmar()
    {
        if ($this->confirmada) {
            throw new Exception("Reserva já foi confirmada anteriormente");
        }

        if (empty($this->hospedes)) {
            throw new Exception("É necessário adicionar pelo menos um hóspede à reserva");
        }

        // Tenta reservar o quarto
        if (!$this->quarto->reservar()) {
            throw new Exception("Não foi possível reservar o quarto. Pode ter sido ocupado por outro cliente");
        }

        $this->confirmada = true;
        
        // Salva dados da reserva
        $this->salvarReserva();
        
        return true;
    }

    /**
     * Salva os dados da reserva em arquivo JSON
     */
    private function salvarReserva()
    {
        $dados_reserva = [
            'id' => $this->id_reserva,
            'data_reserva' => $this->data_reserva,
            'quarto' => [
                'numero' => $this->quarto->getNumero(),
                'tipo' => $this->quarto->getTipo(),
                'preco' => $this->quarto->getPreco(),
                'descricao' => $this->quarto->getDescricao()
            ],
            'hospedes' => [],
            'servicos' => [],
            'total_quarto' => $this->quarto->getPreco(),
            'total_servicos' => $this->calcularTotalServicos(),
            'total_geral' => $this->calcularTotal(),
            'confirmada' => $this->confirmada
        ];

        // Adiciona dados dos hóspedes
        foreach ($this->hospedes as $hospede) {
            $dados_reserva['hospedes'][] = [
                'nome' => $hospede->getNome(),
                'email' => $hospede->getEmail(),
                'tipo' => $hospede->getTipo()
            ];
        }

        // Adiciona dados dos serviços
        foreach ($this->servicos as $servico) {
            $dados_reserva['servicos'][] = [
                'descricao' => $servico->getDescricao(),
                'preco_base' => $servico->calcularPreco($this->hospedes[0] ?? null)
            ];
        }

        // Salva em arquivo
        $arquivo_reservas = __DIR__ . '/../data/reservas.json';
        
        // Cria diretório se não existir
        $dir = dirname($arquivo_reservas);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Carrega reservas existentes
        $reservas_existentes = [];
        if (file_exists($arquivo_reservas)) {
            $json_existente = file_get_contents($arquivo_reservas);
            $reservas_existentes = json_decode($json_existente, true) ?: [];
        }

        // Adiciona nova reserva
        $reservas_existentes[] = $dados_reserva;

        // Salva de volta
        file_put_contents($arquivo_reservas, json_encode($reservas_existentes, JSON_PRETTY_PRINT));
    }

    /**
     * Cancela a reserva e libera o quarto
     */
    public function cancelar()
    {
        if (!$this->confirmada) {
            throw new Exception("Não é possível cancelar uma reserva não confirmada");
        }

        // Libera o quarto
        $this->quarto->liberar();
        $this->confirmada = false;

        return true;
    }

    /**
     * Retorna um resumo da reserva para exibição
     */
    public function getResumo(): array
    {
        return [
            'id' => $this->id_reserva,
            'data_reserva' => $this->data_reserva,
            'quarto' => [
                'numero' => $this->quarto->getNumero(),
                'tipo' => $this->quarto->getTipoNome(),
                'preco' => $this->quarto->getPreco()
            ],
            'total_hospedes' => count($this->hospedes),
            'total_servicos' => count($this->servicos),
            'valor_total' => $this->calcularTotal(),
            'confirmada' => $this->confirmada
        ];
    }

    // ========== GETTERS ==========
    
    public function getQuarto(): Quarto
    {
        return $this->quarto;
    }

    public function getHospedes(): array
    {
        return $this->hospedes;
    }

    public function getServicos(): array
    {
        return $this->servicos;
    }

    public function isConfirmada(): bool
    {
        return $this->confirmada;
    }

    public function getId(): string
    {
        return $this->id_reserva;
    }

    public function getDataReserva(): string
    {
        return $this->data_reserva;
    }

    /**
     * Verifica se a reserva tem Pessoa Jurídica
     */
    public function temPessoaJuridica(): bool
    {
        foreach ($this->hospedes as $hospede) {
            if ($hospede->getTipo() === "Juridica") {
                return true;
            }
        }
        return false;
    }
}