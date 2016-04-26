<?php

require dirname(dirname(__FILE__)) . '/Cinstant.php';

class CinstantTest extends PHPUnit_Framework_TestCase
{
    /**************************************************************************
     * Animated GIF | Standart Image
     **************************************************************************/
     
     public function imgProvider(){
        return array(
            'fill hostname to relative image path' => array(
                'lorem <figure><img src="/media/image/1.png"></figure> ipsum',
                'lorem <figure><img src="http://localhost/media/image/1.png"></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'convert parent to figure' => array(
                'lorem <p><img src="http://localhost"></p> ipsum',
                'lorem <figure><img src="http://localhost"></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'convert parent and set figcaption if only #text in it' => array(
                'lorem <p><img src="http://localhost">Im caption</p> ipsum',
                'lorem <figure><img src="http://localhost"><figcaption>Im caption</figcaption></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'convert parent and set figcaption if only #text or inline html tag in it' => array(
                'lorem <p><img src="http://localhost">Im <em>caption</em> <strong>with</strong> <abbr>simple</abbr> tag</p> ipsum',
                'lorem <figure><img src="http://localhost"><figcaption>Im <em>caption</em> <strong>with</strong> <abbr>simple</abbr> tag</figcaption></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'create new parent' => array(
                'lorem <div><img src="http://localhost"><section>lorem ipsum sit</section></div> ipsum',
                'lorem <div><figure><img src="http://localhost"></figure><section>lorem ipsum sit</section></div> ipsum',
                array('localHost' => 'http://localhost')
            )
        );
     }
     
     /**
      * @dataProvider imgProvider
      * @group img 
      */
    public function testImg($html, $result, $options=array()){
        $cins = new Cinstant($html, $options);
        $this->assertEquals($result, $cins->article);
    }
    
    /**************************************************************************
     * Interactive
     **************************************************************************/
     
     public function iframeProvider(){
        return array(
            'fill hostname to relative iframe path' => array(
                'lorem <figure><iframe src="/media"></iframe></figure> ipsum',
                'lorem <figure class="op-interactive"><iframe src="http://localhost/media"></iframe></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'convert parent to figure' => array(
                'lorem <p><iframe src="http://localhost"></iframe></p> ipsum',
                'lorem <figure class="op-interactive"><iframe src="http://localhost"></iframe></figure> ipsum'
            ),
            'convert parent and set figcaption if only #text in it' => array(
                'lorem <p><iframe src="http://localhost"></iframe>Im caption</p> ipsum',
                'lorem <figure class="op-interactive"><iframe src="http://localhost"></iframe><figcaption>Im caption</figcaption></figure> ipsum'
            ),
            'convert parent and set figcaption if only #text or inline html tag in it' => array(
                'lorem <p><iframe src="http://localhost"></iframe>Im <em>caption</em> <strong>with</strong> <abbr>simple</abbr> tag</p> ipsum',
                'lorem <figure class="op-interactive"><iframe src="http://localhost"></iframe><figcaption>Im <em>caption</em> <strong>with</strong> <abbr>simple</abbr> tag</figcaption></figure> ipsum'
            ),
            'create new parent' => array(
                'lorem <div><iframe src="http://localhost"></iframe><section>lorem ipsum sit</section></div> ipsum',
                'lorem <div><figure class="op-interactive"><iframe src="http://localhost"></iframe></figure><section>lorem ipsum sit</section></div> ipsum'
            ),
            'use op-social instaed for youtube' => array(
                'lorem <div><iframe src="https://www.youtube.com/watch?v=es8lxbExFAQ"></iframe></div> ipsum',
                'lorem <figure class="op-social"><iframe src="https://www.youtube.com/watch?v=es8lxbExFAQ"></iframe></figure> ipsum'
            ),
            'use op-social instaed for vine' => array(
                'lorem <div><iframe src="https://vine.co/v/iUPx0mwh9el/embed/simple"></iframe></div> ipsum',
                'lorem <figure class="op-social"><iframe src="https://vine.co/v/iUPx0mwh9el/embed/simple"></iframe></figure> ipsum'
            )
        );
     }
     
     /**
      * @dataProvider iframeProvider
      * @group iframe
      */
    public function testIframe($html, $result, $options=array()){
        $cins = new Cinstant($html, $options);
        $this->assertEquals($result, $cins->article);
    }
}