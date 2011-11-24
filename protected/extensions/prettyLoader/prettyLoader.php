<?php
/**
 * PrettyLoader class file.
 * This extension http://www.no-margin-for-errors.com/projects/prettyloader/ adapts to use YII
 *
 * @author Bernackiy Alexey <usualdesigner@gmail.com>
 * @authorSite http://bernackiy.name
 * @version 0.1
 */

class PrettyLoader extends CWidget{
    protected $assetsUrl;
    public function init(){
        $this->assetsUrl=Yii::app()->assetManager->publish(dirname(__FILE__).'/assets','',1,YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($this->assetsUrl.'/'.'jquery.prettyLoader.js');
        Yii::app()->clientScript->registerCssFile($this->assetsUrl.'/prettyLoader.css');
        Yii::app()->getClientScript()->registerCoreScript('jquery')
        ->registerScript(__CLASS__. $this->id , '
            $(document).ready(function(){
                    $.prettyLoader({
                        bind_to_ajax: true,
                        loader: "'.$this->assetsUrl.'/ajax-loader.gif",
                    });
            });
        ');
    }
}