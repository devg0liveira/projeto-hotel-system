<?php
namespace Hotel\Utils;

class QuartoPersistence 
{
    private static $arquivo = __DIR__ . '/../data/quartos_status.json';
    
    public static function salvarStatus($dados) 
    {
        // Criar diretório se não existir
        $dir = dirname(self::$arquivo);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        $json = json_encode($dados, JSON_PRETTY_PRINT);
        file_put_contents(self::$arquivo, $json);
    }
    
    public static function carregarStatus() 
    {
        if (!file_exists(self::$arquivo)) {
            return [
                'simples' => 0,
                'suite' => 0, 
                'luxo' => 0
            ];
        }
        
        $json = file_get_contents(self::$arquivo);
        $dados = json_decode($json, true);
        
        return $dados ?: [
            'simples' => 0,
            'suite' => 0,
            'luxo' => 0
        ];
    }
    
    public static function verificarDisponibilidade($tipo) 
    {
        $status = self::carregarStatus();
        $limites = [
            'simples' => 20,
            'suite' => 10,
            'luxo' => 5
        ];
        
        return $status[$tipo] < $limites[$tipo];
    }
    
    public static function reservarQuarto($tipo) 
    {
        if (!self::verificarDisponibilidade($tipo)) {
            return false;
        }
        
        $status = self::carregarStatus();
        $status[$tipo]++;
        self::salvarStatus($status);
        
        return true;
    }
    
    public static function getEstatisticas() 
    {
        $status = self::carregarStatus();
        $limites = [
            'simples' => 20,
            'suite' => 10, 
            'luxo' => 5
        ];
        
        $estatisticas = [];
        foreach ($status as $tipo => $reservados) {
            $estatisticas[$tipo] = [
                'total' => $limites[$tipo],
                'reservados' => $reservados,
                'disponivel' => $limites[$tipo] - $reservados,
                'percentual_ocupacao' => round(($reservados / $limites[$tipo]) * 100, 2)
            ];
        }
        
        return $estatisticas;
    }
}