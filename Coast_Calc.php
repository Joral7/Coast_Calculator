<?php
    # get the data from the form
    $finish_diameter = filter_input(INPUT_POST, 'finish_diameter');
    $wall_thickness = filter_input(INPUT_POST, 'wall_thickness');

    $roller_face = filter_input(INPUT_POST, 'roller_face');
    $line_tension = filter_input(INPUT_POST, 'line_tension');
    $wrap_angle = filter_input(INPUT_POST, 'wrap_angle');

    # Define constants

    # Delta
    $δ = 5;

    # Outer Diameter (finish_diameter)
    $OD = $finish_diameter;

    # Wall Thickness
    $T = $wall_thickness;

    # Inner Diameter
    $ID = $OD - ($T*2);

    # Area Moment of Inertia
    $I = (M_PI/64) * ($OD**4 - $ID**4);
    #echo $I, "\n";

    # Sine calculation for half of the Wrap Angle (WAR for Wrap Angle in Radians)
    $WAR = sin(($wrap_angle*M_PI/180)/(2));
    #echo $WAR, "\n";

    # Width (Roller Face)
    $W = $roller_face**4;
    #echo $W, "\n";
    
    



    # Perform calculation for Aluminum
    $aluminum_P = 0.098;
    $aluminum_E = 1.00E+07;

    # Weight per Inch
    $aluminum_S = ($aluminum_P*(M_PI/4)*($OD**2 - $ID**2));
    #echo $aluminum_S, "\n";
    
    # Load (I'm assuming)
    $aluminum_L = ((2*$line_tension) + 0 + $aluminum_S)*($WAR);
    #echo $aluminum_L, "\n";

    # Aluminum's Deflection Calculation
    $aluminum_D = (($δ*$aluminum_L*$W)/(384*$aluminum_E*$I));



    # Perform calculation for Steel
    $steel_P = 0.284;
    $steel_E = 2.90E+07;

    # Weight per Inch
    $steel_S = ($steel_P*(M_PI/4)*($OD**2 - $ID**2));

    # Load (I'm assuming)
    $steel_L = ((2*$line_tension) + 0 + $steel_S)*($WAR);

    # Steel's Deflection Calculation
    $steel_D = (($δ*$steel_L*$W)/(384*$steel_E*$I));


    # Perform calculation for Stainless
    $stainless_P = 0.2890183;
    $stainless_E = 2.80E+07;

    # Weight per Inch
    $stainless_S = ($stainless_P*(M_PI/4)*($OD**2 - $ID**2));

    # Load (I'm assuming)
    $stainless_L = ((2*$line_tension) + 0 + $stainless_S)*($WAR);

    # Stainless's Deflection Calculation
    $stainless_D = (($δ*$stainless_L*$W)/(384*$stainless_E*$I));

?>

<!DOCTYPE html>
<html>
<head>
<title>Coast Deflection Calculator</title>

<link rel="stylesheet" type="text/css" href="main.css">

</head>
<body>
    <main>

        <div class="header">
            <h2>Roller Deflection Calculator</h2>
        </div>

        <form action="Coast_Calc.php" method="post">

            <div class="row">

                <div class="column">
                    <fieldset>
                            <label>Finish Diameter:</label>
                            <span><?php echo ($finish_diameter); ?></span><br>
                            <br>
                            <br>
                            <label>Inside Diameter:</label>
                            <span><?php echo ($ID); ?></span><br>
                            <br>
                            <br>
                            <label>Wall Thickness:</label>
                            <span><?php echo ($wall_thickness); ?></span><br>
                    </fieldset>                
                </div>

                <div class="column">
                    <fieldset>
                            <label>Roller Face:</label>
                            <span><?php echo ($roller_face); ?></span><br>
                            <br>
                            <br>
                            <label>Line Tension:</label>
                            <span><?php echo ($line_tension); ?></span><br>
                            <br>
                            <br>
                            <label>Wrap Angle:</label>
                            <span><?php echo ($wrap_angle); ?></span><br>
                    </fieldset>
                </div>

                <div class="column">
                    <fieldset>
                            <label>Aluminum Deflection:</label>
                            <span><?php echo ($aluminum_D); ?></span><br>
                            <br>
                            <br>
                            <label>Steel Deflection:</label>
                            <span><?php echo ($steel_D); ?></span><br>
                            <br>
                            <br>
                            <label>Stainless Deflection:</label>
                            <span><?php echo ($stainless_D); ?></span><br>
                    </fieldset>
                </div>

            </div>

        </form>

        <div class="footer">
            <fieldset>
                <h3>Deflection Classifications</h3>
                <br>
                <label for="class_a">Class A - precision or nipped</label>
                <output type="number" name="class_a"></output><br>
                <br>
                <label for="class_b">Class B - dead shaft idlers (most common)</label>
                <output type="number" name="class_b"></output><br>
                <br>
                <label for="class_c">Class C - flexible materials</label>
                <output type="number" name="class_c"></output><br>
                <br>
                <label for="class_d">Class D - conveyors and cores</label>
                <output type="number" name="class_a"></output><br>
                <br>
            </fieldset>
        </div>

    </main>
</body>
</html>