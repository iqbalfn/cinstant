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
            'fill hostname to relative image path 2' => array(
                'lorem <figure><img src="/../../media/image/1.png"></figure> ipsum',
                'lorem <figure><img src="http://localhost/media/image/1.png"></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'fill hostname to relative image path 3' => array(
                'lorem <figure><img src="../../media/image/1.png"></figure> ipsum',
                'lorem <figure><img src="http://localhost/media/image/1.png"></figure> ipsum',
                array('localHost' => 'http://localhost')
            ),
            'not fill hostname to relative image protocol' => array(
                'lorem <figure><img src="//media.com/image/1.png"></figure> ipsum',
                'lorem <figure><img src="//media.com/image/1.png"></figure> ipsum',
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
            'convert parent and ignore figcaption if only empty #text in it' => array(
                'lorem <p><img src="http://localhost"> </p> ipsum',
                'lorem <figure><img src="http://localhost"></figure> ipsum',
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
     * Interactive | social
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
            ),
            'use op-social correctly' => array(
                'lorem <iframe src="https://www.vidio.com/embed/358824-ini-bukti-paris-hilton-komentari-foto-instagram-syahrini"></iframe> ipsum',
                'lorem <figure class="op-interactive"><iframe src="https://www.vidio.com/embed/358824-ini-bukti-paris-hilton-komentari-foto-instagram-syahrini"></iframe></figure> ipsum'
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
    
    /**************************************************************************
     * social
     **************************************************************************/
     
     public function divProvider(){
        return array(
            'make fb video to be op-social' => array(
                'lorem <div data-href="https://www.facebook.com/shanghaiist/videos/10154488047006030/" data-width="670" data-show-text="false" class="fb-video" data-allowfullscreen="true"></div> ipsum',
                'lorem <figure class="op-social"><iframe><div data-href="https://www.facebook.com/shanghaiist/videos/10154488047006030/" data-width="670" data-show-text="false" class="fb-video" data-allowfullscreen="true"></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script></iframe></figure> ipsum',
                array('localHost' => 'http://localhost')
            )
        );
     }
     
     /**
      * @dataProvider divProvider
      * @group div
      */
    public function testDiv($html, $result, $options=array()){
        $cins = new Cinstant($html, $options);
        $this->assertEquals($result, $cins->article);
    }
    
    /**************************************************************************
     * empty tag
     **************************************************************************/
     
     public function emptyProvider(){
        return array(
            'remove empty p tag' => array(
                'lorem <p></p> ipsum',
                'lorem  ipsum'
            ),
            'remove empty p tag with inner space' => array(
                'lorem <p> </p> ipsum',
                'lorem  ipsum'
            ),
            'remove empty p tag with inner spaces' => array(
                'lorem <p>  </p> ipsum',
                'lorem  ipsum'
            )
        );
     }
     
     /**
      * @dataProvider emptyProvider
      * @group div
      */
    public function testEmpty($html, $result, $options=array()){
        $cins = new Cinstant($html, $options);
        $this->assertEquals($result, $cins->article);
    }
}