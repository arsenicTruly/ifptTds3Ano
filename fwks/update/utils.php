<?php
/**
 * Utils - Funcoes utilitarias do framework.
 *
 * Responsavel por traduzir tipos SQL (MySQL) para tipos PHP e para
 * tipos de <input> HTML usados nos formularios gerados.
 */
class Utils
{
    /**
     * Converte um tipo SQL para o tipo PHP correspondente.
     *
     * A regex /\(.*\)/ remove o tamanho/precisao do tipo, por exemplo:
     *   varchar(255) -> varchar
     *   decimal(10,2) -> decimal
     * Assim o match abaixo compara apenas o "nome base" do tipo.
     */
    function converterTipoPHP(string $tipoSQL): string
    {
        $tipoSQL = strtolower($tipoSQL);
        // Remove "(...)" de tipos como varchar(255), decimal(10,2)
        $tipoSQL = preg_replace('/\(.*\)/', '', $tipoSQL);

        return match($tipoSQL){
            'int', 'bigint', 'smallint', 'tinyint' => 'int',
            'varchar', 'char', 'text', 'longtext', 'mediumtext' => 'string',
            'decimal', 'float', 'double', 'real'     => 'float',
            'date', 'datetime', 'timestamp', 'time'   => 'string',
            'bool', 'boolean'                          => 'bool',
            default                                    => 'mixed'
        };
    }

    /**
     * Converte um tipo SQL para o tipo de <input> HTML do formulario.
     * number -> <input type="number">
     * date   -> <input type="date">
     * text   -> <input type="text">
     */
    function converterTipoPHPForm(string $tipoSQL): string
    {
        $tipoSQL = strtolower($tipoSQL);
        $tipoSQL = preg_replace('/\(.*\)/', '', $tipoSQL);

        return match($tipoSQL){
            'int', 'bigint', 'smallint', 'tinyint' => 'number',
            'varchar', 'char', 'text', 'longtext',
            'decimal', 'float', 'double'            => 'text',
            'date', 'datetime', 'timestamp'         => 'date',
            default                                  => 'text'
        };
    }
}
