<?php

/**
 * Class DynamicForm
 * Author Tayfun Erbilen (erbilen.net)
 * Mail tayfunerbilen@gmail.com
 * Web http://www.erbilen.net/lab/DynamicForm/
 */

class DynamicForm {

    // global conf variable
    private $conf;

    // form elements
    private $form = array();

    // variable name
    private $variable;

    // path
    private $path;

    // file name
    private $file;

    // constructer
    public function __construct($setting = NULL){

        // error
        if ( !isset($setting['variable']) || !isset($setting['path']) || !isset($setting['file']) ){
            $this->error('Lütfen aşağıdaki değişkenleri sınıfı başlatırken gönderin.<br />
            <strong>variable</strong> => değişken adı<br />
            <strong>path</strong> => dizin yolu<br />
            <strong>file</strong> => dosya adı');
        }

        // variable name
        $this->variable = $setting['variable'];

        // path
        $this->path = $setting['path'];

        // file name
        $this->file = $setting['file'];

        // divider
        $this->divider = isset($setting['divider']) ? $setting['divider'] : '@@';

        // error
        if ( !file_exists($this->path.'/'.$this->file) ){
            if ( !touch($this->path.'/'.$this->file) ){
                $this->error('<strong>'.$this->path.'/'.$this->file.'</strong> dosyası oluşturulamıyor. Lütfen yazman izinlerini kontrol edin ve tekrar deneyin.');
            }
        }

        require $this->path.'/'.$this->file;

        $this->values = eval('return isset($'.$this->variable.') ? $'.$this->variable.' : NULL;');

        // title
        $this->form['title'] = (isset($setting['title']) ? $setting['title'] : '<h1>{title}</h1>');

        // textarea
        $this->form['textarea'] = (isset($setting['textarea']) ? $setting['textarea'] : '<div class="textarea">
            {text} : {form}<br />
            <p>{desc}</p>
        </div>');

        // input
        $this->form['input'] = (isset($setting['input']) ? $setting['input'] : '<div class="input">
            {text} : {form}<br />
            <p>{desc}</p>
        </div>');

        // select
        $this->form['select'] = (isset($setting['select']) ? $setting['select'] : '<div class="select">
            {text} : {form}<br />
            <p>{desc}</p>
        </div>');

    }

    // set config
    public function config($arr){
        $this->conf = $arr;
    }

    // create dynamic form elements
    public function create(){

        // error
        if ( !$this->conf ){
            $this->error('Dinamik formu oluşturmak için form ayarlarını girin. Bunun için sınıf içindeki <strong>config()</strong> metodunu kullanın.');
        }

        foreach ( $this->conf as $conf ){

            // title
            if ( !isset($conf['name']) ){
                print str_replace(
                    '{title}',
                    $conf[0],
                    $this->form['title']
                );
            }

            // no type = input
            elseif ( !isset($conf['field']) ){
                $input = '<input
                          type="'.(isset($conf['type']) ? $conf['type'] : 'text').'"
                          name="'.(isset($conf['name']) ? $conf['name'] : NULL).'"
                          style="'.(isset($conf['style']) ? $conf['style'] : NULL).'"
                          class="'.(isset($conf['class']) ? $conf['class'] : NULL).'"
                          value="'.(isset($this->values[$conf['name']]) ? $this->values[$conf['name']] : NULL).'" />';
                print str_replace(
                    array(
                        '{form}',
                        '{text}',
                        '{desc}'
                    ),
                    array(
                        $input,
                        (isset($conf['text']) ? $conf['text'] : ''),
                        (isset($conf['desc']) ? $conf['desc'] : '')
                    ),
                    $this->form['input']
                );
            }

            // textarea
            elseif ( $conf['field'] == 'textarea' ){
                $textarea = '<textarea
                          name="'.(isset($conf['name']) ? $conf['name'] : NULL).'"
                          style="'.(isset($conf['style']) ? $conf['style'] : NULL).'"
                          class="'.(isset($conf['class']) ? $conf['class'] : NULL).'">'.(isset($this->values[$conf['name']]) ? $this->values[$conf['name']] : NULL).'</textarea>';
                print str_replace(
                    array(
                        '{form}',
                        '{text}',
                        '{desc}'
                    ),
                    array(
                        $textarea,
                        (isset($conf['text']) ? $conf['text'] : ''),
                        (isset($conf['desc']) ? $conf['desc'] : '')
                    ),
                    $this->form['textarea']
                );
            }

            // select
            elseif ( $conf['field'] == 'select' ){
                $select = '<select
                          name="'.(isset($conf['name']) ? $conf['name'] : NULL).''.(isset($conf['multiple']) ? '[]' : NULL).'"
                          style="'.(isset($conf['style']) ? $conf['style'] : NULL).'"
                          class="'.(isset($conf['class']) ? $conf['class'] : NULL).'"
                          '.(isset($conf['multiple']) ? 'multiple="multiple"' : NULL).'>';

                if ( isset($conf['options']) && gettype($conf['options']) == 'array' ){
                    foreach ( $conf['options'] as $option ){
                        if ( isset($option['value']) && isset($option['text']) ){
                            $select .= '<option value="'.$option['value'].'"'.(isset($this->values[$conf['name']]) && in_array($option['value'], explode($this->divider, $this->values[$conf['name']])) ? 'selected="selected"' : NULL ).'>'.$option['text'].'</option>';
                        }
                    }
                }

                $select .= '</select>';
                print str_replace(
                    array(
                        '{form}',
                        '{text}',
                        '{desc}'
                    ),
                    array(
                        $select,
                        (isset($conf['text']) ? $conf['text'] : ''),
                        (isset($conf['desc']) ? $conf['desc'] : '')
                    ),
                    $this->form['select']
                );
            }

        }

    }

    // update dynamic form elements
    public function update(){

        // error
        if ( !$this->conf ){
            $this->error('Dinamik formu oluşturmak için form ayarlarını girin. Bunun için sınıf içindeki <strong>config()</strong> metodunu kullanın.');
        }

        $content = '<?php'.PHP_EOL;
        foreach ( $this->conf as $conf ){

            if ( isset($conf['name']) ){

                if ( isset($conf['field']) && $conf['field'] == 'select' && isset($conf['multiple']) ){
                    $text = isset($_POST[$conf['name']]) ? implode($this->divider, $_POST[$conf['name']]) : NULL;
                } else {
                    $text = isset($_POST[$conf['name']]) ? $_POST[$conf['name']] : NULL;
                }

                if ( $text )
                    $content .= '$'.$this->variable.'[\''.$conf['name'].'\'] = "'.htmlspecialchars($text).'";'.PHP_EOL;

            }

        }

        return file_put_contents($this->path.'/'.$this->file, $content.'?>');

    }

    // get config
    public function getConf($name = NULL){
        if ( $name ){
            if ( isset($this->values[$name]) )
                return $this->values[$name];
        }
    }

    // error handler
    public function error($msg){
        print '<div style="border: 1px solid darkred; padding: 10px; color: darkred; font-size: 14px;">
            <strong>Hata: </strong>'.$msg.'
        </div>';
        exit;
    }

}
