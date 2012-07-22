<?php
include_once 'exceptions.ipgenerator.class.php';

/**
 * IPGenerator class for generating IPv4 addresses.
 * @author gehaxelt
 * @version 1.0
 */
class IPGenerator {
	/**
	 * First bracket of the IP address
	 * @var int $bracket_1
	 */
	private $bracket_1 = 0;
	
	/**
	 * Second bracket of the IP address
	 * @var int $bracket_2
	 */
	private $bracket_2 = 0;
	
	/**
	 * Third bracket of the IP address
	 * @var int $bracket_3
	 */
	private $bracket_3 = 0;
	
	/**
	 * Fourth bracket of the IP address
	 * @var int $bracket_4
	 */
	private $bracket_4 = 0;
	
	/**
	 * First backet of end IP address
	 * @var int $stopBracket_1
	 */
	private $stopBracket_1=255;
	
	/**
	 * Secoond backet of end IP address
	 * @var int $stopBracket_2
	 */
	private $stopBracket_2=255;
	
	/**
	 * Third backet of end IP address
	 * @var int $stopBracket_3
	 */
	private $stopBracket_3=255;
	
	/**
	 * Fourth backet of end IP address
	 * @var int $stopBracket_4
	 */
	private $stopBracket_4=255;
	
	/**
	 * Constructor with optional set of IP adress
	 * @param int $bracket_1 - First start IP bracket - Default value: 0
	 * @param int $bracket_2 - Second start IP  bracket - Default value: 0
	 * @param int $bracket_3 - Third start IP bracket - Default value: 0
	 * @param int $bracket_4 - Fourth start IP bracket - Default value: 0
	 * @param int $stopBracket_1 - First stop IP bracket - Default value: 255
	 * @param int $stopBracket_2 - Second stop IP bracket - Default value: 255
	 * @param int $stopBracket_3 - Third stop IP bracket - Default value: 255
	 * @param int $stopBracket_4 - Fourth stop IP bracket - Default value: 255
	 */
	public function __construct($bracket_1=0,$bracket_2=0,$bracket_3=0,$bracket_4=0, $stopBracket_1=255,$stopBracket_2=255,$stopBracket_3=255,$stopBracket_4=255) {
		
		$this->setStartIP($bracket_1, $bracket_2, $bracket_3, $bracket_4);
		$this->setStopIP($stopBracket_1, $stopBracket_2, $stopBracket_3, $stopBracket_4);
	}
	
	/**
	 * Setting the beginning IP address from which the generator will start.
	 * @param int $bracket_1 - First bracket
	 * @param int $bracket_2 - Second bracket
	 * @param int $bracket_3 - Third bracket
	 * @param int $bracket_4 - Fourth bracket
	 * @throws NotAnIntegerException
	 * @throws BracketOutOfRangeException
	 */
	public function setStartIP($bracket_1,$bracket_2,$bracket_3,$bracket_4) {
		
		if(!is_int($bracket_1))
			throw new NotAnIntegerException('First parameter is not an integer');
		
		if(!is_int($bracket_2))
			throw new NotAnIntegerException('Second parameter is not an integer');
		
		if(!is_int($bracket_3))
			throw new NotAnIntegerException('Third parameter is not an integer');
		
		if(!is_int($bracket_4))
			throw new NotAnIntegerException('Fourth parameter is not an integer');
		
		if($bracket_1<0 || $bracket_1 > 255)
			throw new BracketOutOfRangeException('First parameter is not between 0-255');
		
		if($bracket_2<0 || $bracket_2 > 255)
			throw new BracketOutOfRangeException('Second parameter is not between 0-255');
		
		if($bracket_3<0 || $bracket_3 > 255)
			throw new BracketOutOfRangeException('Third parameter is not between 0-255');
		
		if($bracket_4<0 || $bracket_4 > 255)
			throw new BracketOutOfRangeException('Fourth parameter is not between 0-255');
		
		$this->bracket_1 = $bracket_1;
		$this->bracket_2 = $bracket_2;
		$this->bracket_3 = $bracket_3;
		$this->bracket_4 = $bracket_4;
	}
	
	/**
	 * Setting the stop IP address at which the generator will stop.
	 * @param int $bracket_1 - First bracket
	 * @param int $bracket_2 - Second bracket
	 * @param int $bracket_3 - Third bracket
	 * @param int $bracket_4 - Fourth bracket
	 * @throws NotAnIntegerException
	 * @throws BracketOutOfRangeException
	 */
	public function setStopIP($stopBracket_1,$stopBracket_2,$stopBracket_3,$stopBracket_4) {

		if(!is_int($stopBracket_1))
			throw new NotAnIntegerException('First parameter is not an integer');
		
		if(!is_int($stopBracket_2))
			throw new NotAnIntegerException('Second parameter is not an integer');
		
		if(!is_int($stopBracket_3))
			throw new NotAnIntegerException('Third parameter is not an integer');
		
		if(!is_int($stopBracket_4))
			throw new NotAnIntegerException('Fourth parameter is not an integer');
		
		if($stopBracket_1<0 || $stopBracket_1 > 255)
			throw new BracketOutOfRangeException('First parameter is not between 0-255');
		
		if($stopBracket_2<0 || $stopBracket_2 > 255)
			throw new BracketOutOfRangeException('Second parameter is not between 0-255');
		
		if($stopBracket_3<0 || $stopBracket_3 > 255)
			throw new BracketOutOfRangeException('Third parameter is not between 0-255');
		
		if($stopBracket_4<0 || $stopBracket_4 > 255)
			throw new BracketOutOfRangeException('Fourth parameter is not between 0-255');
		
		if(!($stopBracket_1>=$this->bracket_1))
			throw new StopIPLowerCurrentIPException('Stop IP is lower than the current IP. ');
		
		$this->stopBracket_1 = $stopBracket_1;
		$this->stopBracket_2 = $stopBracket_2;
		$this->stopBracket_3 = $stopBracket_3;
		$this->stopBracket_4 = $stopBracket_4;
	}
	
	/**
	 * Unsets the IP address marked as stop IP address. Generator will not stop.
	 */
	public function unsetStopIPaddress() {
		$this->stopBracket_1 = 255;
		$this->stopBracket_2 = 255;
		$this->stopBracket_3 = 255;
		$this->stopBracket_4 = 255;
	}
	
	/**
	 * Checks whether a next IP address is avaiable.
	 * @return boolean true if new IP address is avaiable
	 * @return boolean false if IP equals stop IP address 
	 **/
	public  function isNextIPaddress() {
		
		if($this->bracket_1 == $this->stopBracket_1 && $this->bracket_2 == $this->stopBracket_2 && $this->bracket_3 == $this->stopBracket_3 && $this->bracket_4 == $this->stopBracket_4)
			return false;
		
		return true;
	}
	
	/**
	 * Returns the current IP address as string.
	 * @return string IP address xxxx.xxxx.xxxx.xxxx
	 */
	public function getCurrentIPaddress() {
		return $this->bracket_1.".".$this->bracket_2.".".$this->bracket_3.".".$this->bracket_4;
	}
	
	/**
	 * Generates the next IPaddress and returns it.
	 * @throws EndOfIPRangeException
	 * @return string IPaddress
	 */
	public function getNextIPaddress() {
		if(!$this->isNextIPaddress())
			throw new EndOfIPRangeException('No new IP avaiable.');
		
		if($this->bracket_4==255) { //xxxx.xxxx.xxxx.255 ?
			$this->bracket_4=0; //xxxx.xxxx.xxxx.0 
			
			if($this->bracket_3==255) { //xxxx.xxxx.255.255 ?
				$this->bracket_3=0; //xxxx.xxxx.0.0 
				
				if($this->bracket_2==255) { //xxxx.255.255.255 ?
					$this->bracket_2=0; //xxxx.0.0.0 
					$this->bracket_1++; //255.255.255.255 catched by isNextIPaddress in the beginning of the method -> inc first bracket
					
				} else {
					$this->bracket_2++; //inc second bracket
				}
				
			} else {
				$this->bracket_3++; //inc third bracket
			}
			
		} else {
			$this->bracket_4++; //inc fourth bracket
		}
		
		return $this->getCurrentIPaddress();
	}
	
	/**
	 * Getter method of the first start bracket.
	 * @return int first StartBracket
	 */
	public function getFirstStartBracket() {
		return $this->Bracket_1;
	}
	
	/**
	 * Getter method of the second start bracket.
	 * @return int second StartBracket
	 */
	public function getSecondStartBracket() {
		return $this->Bracket_2;
	}
	
	/**
	 * Getter method of the third start bracket.
	 * @return int third StartBracket
	 */
	public function getThirdStartBracket() {
		return $this->Bracket_3;
	}
	
	/**
	 * Getter method of the fourth start bracket.
	 * @return int fourth StartBracket
	 */
	public function getFourthStartBracket() {
		return $this->Bracket_4;
	}
	
	/**
	 * Getter method of the first Stop bracket.
	 * @return int first StopBracket
	 */
	public function getFirstStopBracket() {
		return $this->StopBracket_1;
	}
	
	/**
	 * Getter method of the second Stop bracket.
	 * @return int second StopBracket
	 */
	public function getSecondStopBracket() {
		return $this->StopBracket_2;
	}
	
	/**
	 * Getter method of the third Stop bracket.
	 * @return int third StopBracket
	 */
	public function getThirdStopBracket() {
		return $this->StopBracket_3;
	}
	
	/**
	 * Getter method of the fourth Stop bracket.
	 * @return int fourth StopBracket
	 */
	public function getFourthStopBracket() {
		return $this->StopBracket_4;
	}
	
}
?>