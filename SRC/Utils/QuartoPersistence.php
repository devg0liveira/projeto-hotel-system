<?php
namespace Hotel\Utils;

/**
 * Classe responsável por gerenciar a persistência dos dados de quartos
 * Controla quantos quartos de cada tipo estão ocupados
 */
class QuartoPersistence 
{
    private static $arquivo = __DIR__ . '/../data/quartos_status.json';
    
    /**
     * Salva o status atual dos quartos no arquivo JSON
     */
    public static function salvarStatus($dados) 
    {
        // Criar diretório se não existir
        $dir = dirname(self::$arquivo);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $json = json_encode($dados, JSON_PRETTY_PRINT);
        return file_put_contents(self::$arquivo, $json) !== false;
    }
    
    /**
     * Carrega o status atual dos quartos do arquivo JSON
     */
    public static function carregarStatus() 
    {
        if (!file_exists(self::$arquivo)) {
            // Se não existe, cria com valores zerados
            $status_inicial = [
                'simples' => 0,
                'suite' => 0, 
                'luxo' => 0
            ];
            self::salvarStatus($status_inicial);
            return $status_inicial;
        }
        
        $json = file_get_contents(self::$arquivo);
        $dados = json_decode($json, true);
        
        // Se arquivo está corrompido, reinicia
        if (!$dados || !is_array($dados)) {
            $status_inicial = [
                'simples' => 0,
                'suite' => 0,
                'luxo' => 0
            ];
            self::salvarStatus($status_inicial);
            return $status_inicial;
        }
        
        return $dados;
    }
    
    /**
     * Verifica se há quartos disponíveis de um tipo específico
     */
    public static function verificarDisponibilidade($tipo) 
    {
        $status = self::carregarStatus();
        $limites = [
            'simples' => 20,
            'suite' => 10,
            'luxo' => 5
        ];
        
        return isset($status[$tipo]) && $status[$tipo] < $limites[$tipo];
    }
    
    /**
     * Reserva um quarto e retorna o número atribuído
     */
    public static function reservarQuarto($tipo) 
    {
        if (!self::verificarDisponibilidade($tipo)) {
            return false;
        }
        
        $status = self::carregarStatus();
        $bases_numeracao = [
            'simples' => 100, // 101, 102, 103...
            'suite' => 200,   // 201, 202, 203...
            'luxo' => 300     // 301, 302, 303...
        ];
        
        // Incrementa a quantidade ocupada
        $status[$tipo]++;
        
        // Gera o número do quarto
        $numero_quarto = $bases_numeracao[$tipo] + $status[$tipo];
        
        // Salva o novo status
        if (self::salvarStatus($status)) {
            return $numero_quarto;
        }
        
        return false;
    }
    
    /**
     * Libera um quarto (para cancelamentos)
     */
    public static function liberarQuarto($tipo) 
    {
        $status = self::carregarStatus();
        
        if (!isset($status[$tipo]) || $status[$tipo] <= 0) {
            return false;
        }
        
        $status[$tipo]--;
        return self::salvarStatus($status);
    }
    
    /**
     * Retorna estatísticas completas dos quartos
     */
    public static function getEstatisticas() 
    {
        $status = self::carregarStatus();
        $limites = [
            'simples' => 20,
            'suite' => 10, 
            'luxo' => 5
        ];
        
        $nomes = [
            'simples' => 'Quartos Simples',
            'suite' => 'Suítes',
            'luxo' => 'Suítes Luxo'
        ];
        
        $estatisticas = [];
        foreach ($status as $tipo => $ocupados) {
            $total = $limites[$tipo];
            $disponivel = $total - $ocupados;
            $percentual = $total > 0 ? round(($ocupados / $total) * 100, 2) : 0;
            
            $estatisticas[$tipo] = [
                'nome' => $nomes[$tipo],
                'total' => $total,
                'ocupados' => $ocupados,
                'disponivel' => $disponivel,
                'percentual_ocupacao' => $percentual,
                'status' => $disponivel > 0 ? 'Disponível' : 'Esgotado'
            ];
        }
        
        return $estatisticas;
    }
    
    /**
     * Reseta todos os quartos (para testes ou limpeza)
     */
    public static function resetarQuartos() 
    {
        $status_limpo = [
            'simples' => 0,
            'suite' => 0,
            'luxo' => 0
        ];
        
        return self::salvarStatus($status_limpo);
    }
    
    /**
     * Retorna um relatório formatado
     */
    public static function getRelatorio() 
    {
        $stats = self::getEstatisticas();
        $relatorio = "=== RELATÓRIO DE OCUPAÇÃO ===\n\n";
        
        foreach ($stats as $tipo => $dados) {
            $relatorio .= "{$dados['nome']}:\n";
            $relatorio .= "  Total: {$dados['total']} quartos\n";
            $relatorio .= "  Ocupados: {$dados['ocupados']}\n";
            $relatorio .= "  Disponíveis: {$dados['disponivel']}\n";
            $relatorio .= "  Ocupação: {$dados['percentual_ocupacao']}%\n";
            $relatorio .= "  Status: {$dados['status']}\n\n";
        }
        
        return $relatorio;
    }
}