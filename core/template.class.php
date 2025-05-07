<?php
namespace Bear\Layout;
use PDO;
class Template {
    private $vars = array();
    private $l_delim = '{',
            $r_delim = '}';

    
            public function assign( $key, $value ) {
        $this->vars[$key] = $value;
    }

    public function parse( $template_file ) {
        if ( file_exists( $template_file ) ) {
            $content = file_get_contents($template_file);

            foreach ( $this->vars as $key => $value ) {
                if ( is_array( $value ) ) {
                    $content = $this->parsePair($key, $value, $content);
                } else {
                    $content = $this->parseSingle($key, (string) $value, $content);
                }
            }

            eval( '?> ' . $content . '<?php ' );
        } else {
            exit( '<h1>Template error</h1>' );
        }
    }

    public static function informacao($db,$dado) {
        $dados  = $db->query("
        SELECT *
        FROM config
        ");
        $config = $dados->fetch(PDO::FETCH_ASSOC);
        return $config[$dado];
    }

    public static function diretorio($db, $raiz) {
        $dados  = $db->query("
        SELECT template
        FROM config
        ");
        $config = $dados->fetch(PDO::FETCH_ASSOC);
        $path = $raiz.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.$config['template'].DIRECTORY_SEPARATOR;
        return $path;
    }    

    private function parseSingle( $key, $value, $string, $index = null ) {
        if ( isset( $index ) ) {
            $string = str_replace( $this->l_delim . '%index%' . $this->r_delim, $index, $string );
        }
        return str_replace( $this->l_delim . $key . $this->r_delim, $value, $string );
    }

    private function parsePair( $variable, $data, $string ) {
        $match = $this->matchPair($string, $variable);
        if( $match == false ) return $string;

        $str = '';
        foreach ( $data as $k_row => $row ) {
            $temp = $match['1'];
            foreach( $row as $key => $val ) {
                if( !is_array( $val ) ) {
                    $index = array_search( $k_row, array_keys( $data ) );
                    $temp = $this->parseSingle( $key, $val, $temp, $index );
                } else {
                    $temp = $this->parsePair( $key, $val, $temp );
                }
            }
            $str .= $temp;
        }

        return str_replace( $match['0'], $str, $string );
    }

    private function matchPair( $string, $variable ) {
        if ( !preg_match("|" . preg_quote($this->l_delim) . 'loop ' . $variable . preg_quote($this->r_delim) . "(.+?)". preg_quote($this->l_delim) . 'end loop' . preg_quote($this->r_delim) . "|s", $string, $match ) ) {
            return false;
        }

        return $match;
    }

    

}
        