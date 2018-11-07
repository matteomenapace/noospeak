
<?php

/*
HTML Tag Cloud
HTML_TagCloud enables you to generate a "tag cloud" in HTML.
PHP version 5
@category   HTML
@package    HTML_TagCloud
@author     Shoma Suzuki <shoma@catbot.net>
@copyright  2006 Shoma Suzuki
@license    http://www.php.net/license/3_01.txt  PHP License 3.01
@version    CVS: $Id: TagCloud.php,v 1.1 2006/10/01 05:14:14 shomas Exp $
@see        http://search.cpan.org/~lyokato/HTML-TagCloud-Extended-0.10/lib/HTML/TagCloud/Extended.pm
*/
class HTML_TagCloud {
	// @var    int 
    var $baseFontSize = 36;
	// @var    int 
    var $fontSizeRange = 24;
	// Tag size range in ($basefontsize - $fontsizerange) to ($basefontsize + $fontsizerange).
	// @var    string 
    var $cssClass = 'tagcloud';
	// @var    string 
	// mm,cm,in,pt,pc,px,em
    var $sizeSuffix = 'px';
	// @var    array 
    var $epocLevel = array(
        array(
            'earliest' => array(
                'link'    => '999',
                'visited' => '999',
                'hover'   => '00f',
                'active'  => '00f',
            ),
        ),
        array(
            'earlier' => array(
                'link'    => '666',
                'visited' => '666',
                'hover'   => '00f',
                'active'  => '00f',
            ), 
        ),
        array(
            'later' => array(
                'link'    => '333',
                'visited' => '333',
                'hover'   => '00f',
                'active'  => '00f',
            ),
        ),
        array(
            'latest' => array(
                'link'    => '000',
                'visited' => '000',
                'hover'   => '00f',
                'active'  => '00f',
            ),
        ),
    );
	// @var    array 
    var $_elements = array();
	// @var    int 
    var $_max = 0;
	// @var    int 
    var $_min = 0;
	// @var    int 
    var $_maxEpoc;
	// @var    int 
    var $_minEpoc;
	// @var    float 
    var $_factor = 1;
	// @var    float 
    var $_epocFactor = 1;

	// Class constructor
	// @param   int $baseFontSize    base font size of output tag (option)
	// @param   int $fontSizeRange   font size range
     function HTML_TagCloud($baseFontSize = 36, $fontSizeRange = 24) {
		 $this->baseFontSize = $baseFontSize;
		 $this->fontSizeRange = $fontSizeRange;
		 if ($this->baseFontSize - $this->fontSizeRange > 0){
		 	$this->minFontSize = $this->baseFontSize - $this->fontSizeRange;
		} else {
			$this->minFontSize = 0;
		}
		$this->maxFontSize = $this->baseFontSize + $this->fontSizeRange;
	}


	// add a Tag Element to build Tag Cloud
	// @return  void 
	// @param   string  $tag 
	// @param   string  $url 
	// @param   int     $count 
	// @param   int     $timestamp unixtimestamp
     function addElement($name = '', $url ='', $count = 0, $timestamp = null) {
		$i = count($this->_elements);
		$this->_elements[$i]['name'] = $name;
		$this->_elements[$i]['url'] = $url;
		$this->_elements[$i]['count'] = $count;
		$this->_elements[$i]['timestamp'] = $timestamp == null ? time() : $timestamp;
	}

	// add a Tag Element to build Tag Cloud
	// @return  void 
	// @param   array   $tags Associative array to $this->_elements
     function addElements($tags) {
		$this->_elements = array_merge($this->_elements, $tags);
	}

     function clearElements() {
		$this->_elements = array();
	}

	// build HTML and CSS at once.
	// @return  string HTML and CSS
	// @param   array $param 
	// @see     _buidHTMLTags
	 function buildAll($param = array()) {
			$html = '<style type="text/css">'."\n";
			$html .= $this->buildCSS()."</style>\n";
			$html .= $this->buildHTML($param);
			return $html;
	}

	// Alias to buildAll. Compatibilities for Perl Module.
	// @return  string HTML and CSS
	// @param   array  $param 'limit' => int limit of generation tag num.
     function html_and_css($param = array()){
		return $this->buildAll($param);
	}
	
	// build HTML part
	// @return  string HTML
	// @param   array  $param 'limit' => int limit of generation tag num.
     function buildHTML($param = array()) {
		$htmltags = $this->_buidHTMLTags($param);
		return $this->_wrapDiv($htmltags);
	}
	
	// build CSS part
	// @return  string base CSS
	// @access  public
	 function buildCSS() {
		$css = '';
		foreach ($this->epocLevel as $item) {
			foreach ($item as $epocName => $colors) {
				foreach ($colors as $attr => $color) {
					$css .= "a.{$epocName}:{$attr} {text-decoration: none; color: #{$color};}\n";
				}
			}
        }
        return $css;
    }

	// calculate Tag level and create whole HTML of each Tags
	// @return  string HTML
	//@param   array $param limit of Tag Number
     function _buidHTMLTags($param) {
		$this->total = count($this->_elements);
		// no tags elements
		if ($this->total == 0) {
		 	return array();
		} elseif ($this->total == 1) {
		 	$tag = $this->_elements[0];
			return $this->_createHTMLTag($tag, 'latest', $this->baseFontSize);
		}
		$limit = array_key_exists('limit', $param) ? $param['limit'] : 0;
		//echo ("limit: ". $limit . "<br>");
		$this->_sortTags($limit);
		$this->_calcMumCount();
		$this->_calcMumEpoc();
		$range = $this->maxFontSize - $this->minFontSize;
		//echo ("range: ". $range . "<br>");
		if ($this->_max != $this->_min) {
		 	$this->_factor = $range / (sqrt($this->_max) - sqrt($this->_min));
		} else {
			$this->_factor = 1;
		}
		//echo ("factor: ". $this->_factor . "<br>");
		if ($this->_maxEpoc != $this->_minEpoc) {
			$this->_epocFactor = count($this->epocLevel) / (sqrt($this->_maxEpoc) - sqrt($this->_minEpoc));
		} else {
			$this->_epocFactor = 1;
		}
		$rtn = array();
		foreach ($this->_elements as $tag) {
			//echo ("<b>$tag[name]</b>:<br>");
			$countLv = $this->_getCountLevel($tag['count']);
			//echo ("final count: ". $countLv . "<br>");
			if (! isset($tag['timestamp']) || empty($tag['timestamp'])) {
			 	$epocLv = count($this->epocLevel) - 1;
			} else {
				$epocLv  = $this->_getEpocLevel($tag['timestamp']);
			}
			$colorType = $this->epocLevel[$epocLv];
			$fontSize  = $this->minFontSize + $countLv;
			// echo ("$tag[name] size: ". $fontSize . "<br>");
			$rtn[] = $this->_createHTMLTag($tag, key($colorType), $fontSize);
		}
		return implode("", $rtn);
	}

// create a Element of HTML part
// @return  string a Element of Tag HTML
// @param   array  $tag 
// @param   string $type css class of time line param
// @param   float  $fontSize 
	function _createHTMLTag($tag, $type, $fontSize) {
		return '<a href="'. $tag['url'] . '" style="font-size: '. $fontSize . $this->sizeSuffix . ';" class="'.  $type .'">' . htmlspecialchars($tag['name']) . '</a>&nbsp;'. "\n";
	}

	// sort tags by name
	// @return  array 
	// @param   int  $limit limit element number of create TagCloud
	// @access  private
	 function _sortTags($limit = 0) {
		usort($this->_elements, array($this, "_cmpElementsName"));
		if ($limit != 0) { 
			$this->_elements = array_splice($this->_elements, 0, $limit);
		}
    }

	// using for usort()
	// @return  int (bool)
     function _cmpElementsName($a, $b) {
		if ($a['name'] == $b['name']) {
			return 0;
        }
        return ($a['name'] < $b['name']) ? -1 : 1;
    }

    // calculate max and min tag count of use
	// @access  private
     function _calcMumCount(){
        foreach ($this->_elements as $item) {
            $array[] = $item['count'];
        }
        $this->_min = min($array);
        $this->_max = max($array);
		//print ("max is " . $this->_max . " and min is " . $this->_min . "<br>");
    }

	// calculate max and min timestamp
     function _calcMumEpoc() {
        foreach ($this->_elements as $item) {
            $array[] = $item['timestamp'];
        }
        $this->_minEpoc = min($array);
        $this->_maxEpoc = max($array);
    }

	// calculate Tag Level of size
	// @return  int level
	// @param   int $count 
     function _getCountLevel($count = 0) {
		//echo ("count: " . $count . "<br>");
		$countLevel = round((sqrt($count) - sqrt($this->_min) ) * $this->_factor);
		//echo ("countLevel: " . $countLevel . "<br>");
		return $countLevel;
        /* return (int)(sqrt($count) - sqrt($this->_min) ) * $this->_factor; BUGGY CODE*/
    }
	// calc timeline level of Tag
	// @return  int     level of timeline
	// @param   int     $timestamp 
     function _getEpocLevel($timestamp = 0) {
		// echo ("timestamp: " . $timestamp . "<br>");
		// echo ("timestamp sqrt: " . sqrt($timestamp) . "<br>");
		$epocLevel = (sqrt($timestamp) - sqrt($this->_minEpoc)) * $this->_epocFactor;
		if ($epocLevel>=4) {
			$epocLevel=3;
		}
		// echo ("epocLevel: " . $epocLevel . "<br>");
		return $epocLevel;
        //return (int) (sqrt($timestamp) - sqrt($this->_minEpoc)) * $this->_epocFactor; //BUGGY ORIGINAL CODE
    }

	// wrap div tag
	// @return  string 
	// @param   string $html 
     function _wrapDiv($html) {
        return $html == '' ? '' : '<div class="'.$this->cssClass .'">'.$html.'</div>'."\n";
    }
}

?>