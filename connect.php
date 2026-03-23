<?php

/**
 * Inicia a sessão do PHP apenas se ela ainda não existir.
 * Isso evita o erro "Notice: session_start(): Ignoring session_start()".
 * A sessão é essencial para podermos salvar as mensagens de Sucesso/Erro (Toasts)
 * e exibi-las na tela após o redirecionamento.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Classe responsável por criar e fornecer
 * uma conexão com o banco de dados de forma segura.
 */
class Connect
{
    /**
     * Retorna uma única instância de conexão com o banco.
     *
     * O tipo de retorno ": PDO" informa que este método
     * sempre deve retornar um objeto da classe PDO.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        /**
         * A variável static mantém seu valor entre
         * diferentes chamadas do método.
         *
         * Isso significa que, depois que a conexão for criada
         * pela primeira vez, ela será reaproveitada nas próximas chamadas.
         */
        static $instance = null;

        /**
         * Se ainda não existe conexão, cria uma nova.
         */
        if ($instance === null) {
            
            /**
             * LENDO O ARQUIVO .ENV (Segurança Nível Sênior)
             * Em vez de usar constantes expostas no código, lemos as credenciais
             * de um arquivo externo que não é enviado para o repositório.
             */
            $envPath = __DIR__ . '/.env';
            if (!file_exists($envPath)) {
                die("Erro crítico: Arquivo .env não encontrado na raiz do sistema.");
            }
            $env = parse_ini_file($envPath);

            /**
             * DSN = Data Source Name
             * Monta a string de conexão usando os dados do arquivo .env
             */
            $dsn = "mysql:host=" . $env['DB_HOST'] . ";dbname=" . $env['DB_NAME'] . ";charset=utf8mb4";

            /**
             * Cria a conexão com o banco usando PDO de forma segura.
             */
            try {
                $instance = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], [
                    /**
                     * Faz o PDO lançar exceções em caso de erro.
                     * Isso facilita o tratamento de falhas.
                     */
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                    /**
                     * Define que os resultados das consultas serão
                     * retornados como array associativo.
                     */
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die("Falha na conexão com o Banco de Dados: " . $e->getMessage());
            }
        }

        /**
         * Retorna a instância da conexão.
         * Se ela já existir, retorna a mesma.
         */
        return $instance;
    }
}