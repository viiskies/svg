<?php

$radiusInput = $_POST['radius'];
$xInput = $_POST['x'];
$yInput = $_POST['y'];
$raysInput = $_POST['rays'];

class Text extends Tag {
	public function __construct($x, $y, $text) {
		$this->name = 'text';
		$this->attributes = 
		[
			'x' => $x,
			'y' => $y,
		];
		$this->text = $text;
	}
}

class Triangle extends Tag {
	public function __construct($point1, $point2, $point3, $color = 'orange') {
		$this->name = 'polygon';
		$this->attributes = [
			'points' => $point1->x . ',' . $point1->y . ' ' . $point2->x . ',' . $point2->y . ' ' . $point3->x . ',' . $point3->y,
			'fill' => $color
		];
	}
}

class Tag {
	protected $name;
	protected $attributes;
	protected $text;
	// private $result;
	private $attrString = '';
	
	public function draw() {
		// $attrString = '';
		foreach ($this->attributes as $key => $value) {
			$this->attrString .= $key . '="' . $value . '" ';
		}
		if (isset($this->text)) {
			$this->attrString .= '>' . $this->text . '</text>';
		}
		$result = '<' . $this->name . " " . $this->attrString . '/>';
		return $result;
	}
}

class Point {
	public $x;
	public $y;
	
	function __construct($x, $y) {
		$this->x = $x;
		$this->y = $y;
	}
}

class Rectangle extends Tag {
	public function __construct($x, $y, $width, $height, $color = 'red') {
		$this->name = 'rect';
		$this->attributes = 
		[
			'x' => $x,
			'y' => $y,
			'width' => $width,
			'height' => $height,
			'fill' => $color
		];
	}
}

class Circle extends Tag {
	public function __construct($cx, $cy, $r, $color = 'blue') {
		$this->name = 'circle';
		$this->attributes = 
		[
			'cx' => $cx,
			'cy' => $cy,
			'r' => $r,
			'fill' => $color,
		];
	}
}

class Ray extends Tag {
	public function __construct($x1, $y1, $x2, $y2, $stroke = 5, $rotation, $color = 'yellow') 
	{
		$this->name = 'line';
		$this->attributes = 
		[
			'x1' => $x1,
			'y1' => $y1,
			'x2' => $x2 + 50, // Rotation of ray
			'y2' => $y2 * 0.95, // Lenght of ray
			'style' => 'stroke:' . $color . '; stroke-width:' . $stroke,
			'transform' => 'rotate(' . $rotation .' ' . ($x2) . ',' . ($y2) . ')'
		];
	}
}

class Trapezoid {
	public function __construct($x, $y, $height, $a, $b, $color = 'red')
	{
		$this->x = $x;
		$this->y = $y;
		$this->height = $height;		
		$this->a = $a;
		$this->b = $b;
		$this->color = $color;
	}
	
	public function draw () {
		$result = '';
		
		$triRectPoint = ($this->b - $this->a) / 2;
		$rect = new Rectangle( $triRectPoint + $this->x, $this->y, $this->a, $this->height, $this->color);
		
		$triL = new Triangle(
			new Point(0 + $this->x , $this->height + $this->y), 
			new Point($triRectPoint + $this->x, 0 + $this->y), 
			new Point($triRectPoint + $this->x, $this->height + $this->y),
			$this->color
		);
		
		$triR = new Triangle(
			new Point($this->b + $this->x, $this->height + $this->y), 
			new Point($this->b - $triRectPoint + $this->x, 0 + $this->y), 
			new Point($this->b - $triRectPoint + $this->x, $this->height + $this->y),
			$this->color
		);
		
		$result .= $rect->draw();
		$result .= $triL->draw();
		$result .= $triR->draw();
		
		return $result;
	}
}

class Sun {
	public function __construct($x, $y, $r, $numberRays = 1, $color = 'red')
	{
		$this->x = $x;
		$this->y = $y;
		$this->r = $r;
		$this->numberRays = $numberRays;
		$this->color = $color;
	}
	
	public function draw () {
		$result = '';
		$angleOfRays = 360 / $this->numberRays;
		
		$circ = new Circle( $this->x, $this->y, $this->r, $this->color);
		$result .= $circ->draw();
		
		$circ2 = new Circle( $this->x, $this->y, 10, 'white');
		$result .= $circ2->draw();
				
		for ($i=0; $i < $this->numberRays; $i++) { 
			${'testLine' . $i} = new Ray( $this->x, $this->y - 200, $this->x, $this->y, 20, $i * $angleOfRays, $this->color);
			$result .= ${'testLine' . $i} ->draw();
		}
		
		return $result;
	}
}



////echo '<svg width="1000" height="1000">';
////
//// ************************
//// 		  DRAW SUN
//// ************************
//$sun = new Sun(250, 250, 25, 3, 'orange');
//echo $sun->draw();
//// ************************
$sun = new Sun($xInput, $yInput, $radiusInput, $raysInput, 'orange');
echo $sun->draw();
// ************************
//
//
//// ************************
//// 		 DRAW PICTURE
//// ************************
//// $rect = new Rectangle(200, 0, 500, 200);
//// $circ = new Circle(450, 100, 75);
//// $triLeft = new Triangle(new Point(0,200), new Point(200,0), new Point(200,200));
//// $triRight = new Triangle(new Point(700,200), new Point(700,0), new Point(900,200));
//// $textline = new Text(450, 100, "Hello");
//
//// echo $rect->draw();
//// echo $triLeft->draw();
//// echo $triRight->draw();
//// echo $circ->draw();
//// echo $textline->draw();
//
//
//// ************************
//// 		DRAW TRAPEZOID
//// ************************
//// $trapez = new Trapezoid(0, 0, 80, 180, 300, 'tomato');
//// echo $trapez->draw();
//// ************************
//echo '</svg>';
?>