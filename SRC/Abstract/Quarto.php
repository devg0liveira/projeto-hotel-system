<?php
namespace Hotel\Models\Abstract;

abstract class Quarto
{
    protected $numero;
    protected $tipo;
    protected $preco;
    
    // Quantidades máximas por tipo
    protected static $quantidades_maximas = [
        'simples' => 20,
        'suite' => 10,
        'luxo' => 5
    ];

    public function __construct($tipo, $preco)
    {
        $this->tipo = $tipo;
        $this->preco = $preco;
        // O número será atribuído quando a reserva for confirmada
        $this->numero = null;
    }

    // Métodos abstratos que as classes filhas devem implementar
    abstract public function getDescricao();
    abstract public function getTipoNome();

    /**
     * Verifica se há quartos disponíveis deste tipo
     */
    public static function temDisponibilidade($tipo)
    {
        // Carrega dados do arquivo de persistência
        require_once __DIR__ . '/../Utils/QuartoPersistence.php';
        $persistence = new \Hotel\Utils\QuartoPersistence();
        
        $status = $persistence::carregarStatus();
        return $status[$tipo] < self::$quantidades_maximas[$tipo];
    }

    /**
     * Retorna quantos quartos ainda estão disponíveis
     */
    public static function getQuantidadeDisponivel($tipo)
    {
        require_once __DIR__ . '/../Utils/QuartoPersistence.php';
        $persistence = new \Hotel\Utils\QuartoPersistence();
        
        $status = $persistence::carregarStatus();
        return self::$quantidades_maximas[$tipo] - $status[$tipo];
    }

    /**
     * Reserva um quarto deste tipo
     */
    public function reservar()
    {
        if (!self::temDisponibilidade($this->tipo)) {
            return false;
        }

        require_once __DIR__ . '/../Utils/QuartoPersistence.php';
        $persistence = new \Hotel\Utils\QuartoPersistence();
        
        // Reserva o quarto e obtém o número
        $this->numero = $persistence::reservarQuarto($this->tipo);
        
        return $this->numero !== false;
    }

    /**
     * Libera um quarto (para cancelamentos)
     */
    public function liberar()
    {
        require_once __DIR__ . '/../Utils/QuartoPersistence.php';
        $persistence = new \Hotel\Utils\QuartoPersistence();
        
        return $persistence::liberarQuarto($this->tipo);
    }

    /**
     * Gera número do quarto baseado no tipo e quantidade já ocupada
     */
    private function gerarNumero($tipo, $quantidade_ocupada)
    {
        $bases = [
            'simples' => 100, // Quartos 101-120
            'suite' => 200,   // Quartos 201-210  
            'luxo' => 300     // Quartos 301-305
        ];
        
        return $bases[$tipo] + $quantidade_ocupada + 1;
    }

    // Getters
    public function getPreco()
    {
        return $this->preco;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Retorna estatísticas de todos os tipos de quarto
     */
    public static function getEstatisticasGerais()
    {
        require_once __DIR__ . '/../Utils/QuartoPersistence.php';
        $persistence = new \Hotel\Utils\QuartoPersistence();
        
        return $persistence::getEstatisticas();
    }
}