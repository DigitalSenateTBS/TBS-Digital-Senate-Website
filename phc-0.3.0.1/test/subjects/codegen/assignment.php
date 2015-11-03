<?php
/*
 * Fairly comprehensive test of assignments, dealing with "ordinary" variables,
 * arrays and variable variables, and testing normal assignment and reference 
 * assignment, and tests copy-on-write and change-on-write.
 * 
 * Does not deal with OO stuff, that should probably be tested separately.
 */

/*
 * Simple variables
 */
	// Normal assignment
	$Aa = 10;
	$Ab = $Aa;
	$Ab = $Ab + 1;
	var_export($Aa);
	var_export($Ab);

	// Reference assignment
	$Ac = 20;
	$Ad =& $Ac;
	$Ad = $Ad + 1;
	var_export($Ac);
	var_export($Ad);

	// Normal assignment, RHS is_ref
	$Ae = 30;
	$Af =& $Ae;
	$Ag = $Af;
	$Ag = $Ag + 1;
	var_export($Ae);
	var_export($Af);
	var_export($Ag);

	// Reference assignment, RHS is copy-on-write
	$Ah = 40;
	$Ai = $Ah;
	$Aj =& $Ai;
	$Aj = $Aj + 1;
	var_export($Ah);
	var_export($Ai);
	var_export($Aj);

?>
