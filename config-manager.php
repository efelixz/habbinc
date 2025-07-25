<?php
/**
 * Sistema de Gerenciamento de Configuração
 * Alterna entre ambiente LOCAL (localhost) e ONLINE (190.102.40.98)
 */

class ConfigManager {
    private $environments = [
        'LOCAL' => [
            'DB_HOST' => 'localhost',  // Sempre localhost
            'GAME_HOST' => 'localhost', 
            'RCON_HOST' => '127.0.0.1',
            'SITE_URL' => 'http://localhost',
            'SOCKET_URL' => 'ws://localhost:2096',
            'IMAGE_LIBRARY_URL' => 'https://localhost/swf/c_images/',
            'RENDERER_CONFIG_URL' => 'http://localhost/renderer-config.json',
            'UI_CONFIG_URL' => 'http://localhost/ui-config.json'
        ],
        'ONLINE' => [
            'DB_HOST' => 'localhost',  // MANTÉM localhost para banco
            'GAME_HOST' => '190.102.40.98',
            'RCON_HOST' => '190.102.40.98', 
            'SITE_URL' => 'http://190.102.40.98',
            'SOCKET_URL' => 'ws://190.102.40.98:2096',
            'IMAGE_LIBRARY_URL' => 'http://190.102.40.98/swf/c_images/',
            'RENDERER_CONFIG_URL' => 'http://190.102.40.98/renderer-config.json',
            'UI_CONFIG_URL' => 'http://190.102.40.98/ui-config.json'
        ]
    ];
    
    private $files = [
        'config.ini',
        'htdocs/arc.config.php',
        'htdocs/renderer-config.json', 
        'htdocs/renderer-config2.json',
        'htdocs/structure/files/tema/original/client.php',
        'htdocs/structure/files/tema/original/validar.php',
        'htdocs/structure/files/tema/original/teste.php',
        'htdocs/structure/files/tema/original/perfil.php'
    ];
    
    public function switchEnvironment($environment) {
        if (!isset($this->environments[$environment])) {
            throw new Exception("Ambiente '$environment' não encontrado!");
        }
        
        $config = $this->environments[$environment];
        $this->createBackup();
        
        echo "Alterando para ambiente: $environment\n";
        echo "Host do banco: {$config['DB_HOST']}\n";
        echo "URL do site: {$config['SITE_URL']}\n\n";
        
        // Atualizar config.ini
        $this->updateConfigIni($config);
        
        // Atualizar arc.config.php
        $this->updateArcConfig($config);
        
        // Atualizar renderer configs
        $this->updateRendererConfigs($config);
        
        // Atualizar client.php
        $this->updateClientPhp($config);
        
        // Atualizar arquivos PHP de conexão
        $this->updatePhpConnections($config);
        
        // Atualizar perfil.php (se necessário)
        $this->updatePerfilPhp($config);
        
        echo "✅ Configuração alterada com sucesso para $environment!\n";
    }
    
    private function createBackup() {
        $backupDir = 'backup_' . date('Y-m-d_H-i-s');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        
        foreach ($this->files as $file) {
            if (file_exists($file)) {
                $backupPath = $backupDir . '/' . str_replace('/', '_', $file);
                copy($file, $backupPath);
            }
        }
        
        echo "📁 Backup criado em: $backupDir\n";
    }
    
    private function updateConfigIni($config) {
        $file = 'config.ini';
        if (!file_exists($file)) return;
        
        $content = file_get_contents($file);
        // Banco sempre localhost
        $content = preg_replace('/db\.hostname\s*=\s*.+/', "db.hostname=localhost", $content);
        // Apenas game.host e rcon.host mudam
        $content = preg_replace('/game\.host\s*=\s*.+/', "game.host={$config['GAME_HOST']}", $content);
        $content = preg_replace('/rcon\.host\s*=\s*.+/', "rcon.host={$config['RCON_HOST']}", $content);
        
        file_put_contents($file, $content);
        echo "✅ Atualizado: $file (DB mantido em localhost)\n";
    }
    
    private function updateArcConfig($config) {
        $file = 'htdocs/arc.config.php';
        if (!file_exists($file)) return;
        
        $content = file_get_contents($file);
        // Banco sempre localhost
        $content = preg_replace('/database_hostname\s*=\s*"[^"]+"/', "database_hostname = \"localhost\"", $content);
        // URLs mudam conforme ambiente
        $content = preg_replace('/site\.url\s*=\s*"[^"]+"/', "site.url = \"{$config['SITE_URL']}\"", $content);
        $content = preg_replace('/connection\.info\.host\s*=\s*"[^"]+"/', "connection.info.host = \"{$config['GAME_HOST']}\"", $content);
        
        // Atualizar outras URLs
        if ($config['SITE_URL'] !== 'http://localhost') {
            $content = str_replace('http://localhost', $config['SITE_URL'], $content);
        }
        
        file_put_contents($file, $content);
        echo "✅ Atualizado: $file (DB mantido em localhost)\n";
    }
    
    private function updateRendererConfigs($config) {
        $files = ['htdocs/renderer-config.json', 'htdocs/renderer-config2.json'];
        
        foreach ($files as $file) {
            if (!file_exists($file)) continue;
            
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            
            if ($data) {
                // Atualizar URLs
                if (isset($data['socket.url'])) {
                    $data['socket.url'] = $config['SOCKET_URL'];
                }
                if (isset($data['image.library.url'])) {
                    $data['image.library.url'] = $config['IMAGE_LIBRARY_URL'];
                }
                
                // Atualizar outras URLs que contenham localhost
                $content = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                $content = str_replace('localhost', str_replace(['http://', 'https://'], '', $config['SITE_URL']), $content);
                
                file_put_contents($file, $content);
                echo "✅ Atualizado: $file\n";
            }
        }
    }
    
    private function updateClientPhp($config) {
        $file = 'htdocs/structure/files/tema/original/client.php';
        if (!file_exists($file)) return;
        
        $content = file_get_contents($file);
        $content = str_replace(
            "'http://localhost/renderer-config.json",
            "'{$config['RENDERER_CONFIG_URL']}",
            $content
        );
        $content = str_replace(
            "'http://localhost/ui-config.json",
            "'{$config['UI_CONFIG_URL']}",
            $content
        );
        
        file_put_contents($file, $content);
        echo "✅ Atualizado: $file\n";
    }
    
    private function updatePhpConnections($config) {
        $files = [
            'htdocs/structure/files/tema/original/validar.php',
            'htdocs/structure/files/tema/original/teste.php'
        ];
        
        foreach ($files as $file) {
            if (!file_exists($file)) continue;
            
            $content = file_get_contents($file);
            // Força conexão sempre para localhost
            $content = preg_replace(
                "/new mysqli\s*\(\s*['\"][^'\"]*['\"]/",
                "new mysqli('localhost'",
                $content
            );
            
            file_put_contents($file, $content);
            echo "✅ Atualizado: $file (DB mantido em localhost)\n";
        }
    }
    
    private function updatePerfilPhp($config) {
        $file = 'htdocs/structure/files/tema/original/perfil.php';
        if (!file_exists($file)) return;
        
        // Nota: O arquivo perfil.php contém uma URL externa (habbok.me)
        // que pode precisar ser alterada dependendo do ambiente
        echo "ℹ️  perfil.php contém URL externa (habbok.me) - verifique se precisa ser alterada\n";
    }
    
    public function getCurrentEnvironment() {
        if (file_exists('config.ini')) {
            $content = file_get_contents('config.ini');
            if (strpos($content, 'db.hostname=localhost') !== false) {
                return 'LOCAL';
            } elseif (strpos($content, 'db.hostname=190.102.40.98') !== false) {
                return 'ONLINE';
            }
        }
        return 'UNKNOWN';
    }
}

// Execução via linha de comando
if (php_sapi_name() === 'cli') {
    $manager = new ConfigManager();
    
    if ($argc < 2) {
        echo "Uso: php config-manager.php [LOCAL|ONLINE|STATUS]\n";
        echo "\nComandos:\n";
        echo "  LOCAL  - Configura para ambiente local (localhost)\n";
        echo "  ONLINE - Configura para ambiente online (190.102.40.98)\n";
        echo "  STATUS - Mostra o ambiente atual\n";
        exit(1);
    }
    
    $command = strtoupper($argv[1]);
    
    try {
        if ($command === 'STATUS') {
            $current = $manager->getCurrentEnvironment();
            echo "Ambiente atual: $current\n";
        } else {
            $manager->switchEnvironment($command);
        }
    } catch (Exception $e) {
        echo "❌ Erro: " . $e->getMessage() . "\n";
        exit(1);
    }
}
?>