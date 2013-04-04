<?php

/**
 * Description of grafovalidator
 * grafovalidator - tool for confirmation meeting.
 *
 * @author root
 */
class GrafoValidator extends CWidget 
{

    private $_im;
    
    // - template png - location in components/view
    public $pngCanvas='canvas.png'; 

    // - rnd values for items
    public $rndValues=array();

    // -- view for each item
    public $itemView='_gvItem';
    
    
    
    public function init() 
    {
    parent::init();
    $this->_im = imagecreatefrompng(Yii::getPathOfAlias('application.components.views').'/'.$this->pngCanvas);
    }

    public function run()
    {
    
    foreach($this->rndValues as $rnd)
    {
    
        for ($i=0;$i<16;$i+=2)
        {
        $q=hexdec(substr(md5($rnd),$i,2));
        imagecopy($this->_im, $this->_im, $q%100, 34, 0, 0, 30, 30);
        imagecopy($this->_im, $this->_im, 14,$q%100, 30, 0, 30, 30);
        imagecopy($this->_im, $this->_im, $q%100, 12, 60, 0, 30, 30);
        imagecopy($this->_im, $this->_im, 50, $q%100, 1, 31, 30, 30);
        imagecopy($this->_im, $this->_im, $q%100, 92, 31, 31, 30, 30);
        imagecopy($this->_im, $this->_im, 5, $q%100, 61, 31, 30, 30);
        imagecopy($this->_im, $this->_im, $q%100, 5, 0, 61, 30, 30);
        imagecopy($this->_im, $this->_im, 29, $q%100, 31, 61, 30, 30);
        imagecopy($this->_im, $this->_im, $q%100, 25, 61, 61, 30, 30);
        }
        imagefilter($this->_im, IMG_FILTER_GAUSSIAN_BLUR, IMG_FILTER_EMBOSS);
        $this->render($this->itemView, array('im'=>$this->_im));
     

       
    
     }
        
 }
    

}

?>
