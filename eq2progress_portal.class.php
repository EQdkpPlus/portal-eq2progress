<?php
 /*
 * Project:		EQdkp-Plus
 * License:		Creative Commons - Attribution-Noncommercial-Share Alike 3.0 Unported
 * Link:		http://creativecommons.org/licenses/by-nc-sa/3.0/
 * -----------------------------------------------------------------------
 * Began:		2008
 * Date:		$Date: 2013-01-09 19:20:34 +0100 (Wed, 09 Jan 2013) $
 * -----------------------------------------------------------------------
 * @author		$Author: Darkmaeg $
 * @copyright	2006-2015 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 00037 $
 * 
 * $Id: eq2progress_portal.class.php 00036 2013-11-18 18:20:34Z Darkmaeg $
 * Modified Version of Hoofy's mybars progression module
 * This version populates the guild raid achievements from the Data Api
 *
 * V4.1 Minor Bug Fixes
 * V4.0.1 Bug Fixes
 * V4.0 Added Kunark Ascending
 * V3.9 Added Fabled Fallen Dynasty
 * V3.8 Added The Siege / Removed TLE version
 * V3.7 Added Terrors of Thalumbra
 * V3.6 Combined TLE version
 * V3.5 Added Brell Serilis
 * V3.4 Added Fabled Freethinker's Hideout
 * V3.3 Added Far Seas Distillery
 * V3.2 Changed API from SOE to Daybreak
 * V3.1 Added Precipice of Power Avatars
 * V3.0 Eqdkp+ 2.0 Version of EQ2 Progress
 * V2.0 Added Altar of Malice Raid Zones
 * V1.9 Fixed Bristlebane Achievement ID - Sony changed it from Beta
 * V1.8 Added Age's End
 * V1.7 Added Fabled Deathtoll
 * V1.6 Added Hidden mob in Temple of Veeshan: The Dreadscale's Maw
 * V1.5 Added Temple of Veeshan: The Dreadscale's Maw
 * V1.4 Added Contested X4 in High Keep
 * V1.3 Added Fabled Kingdom of Sky Zones
 *      Added admin menu to choose to display kill dates
 * V1.2 Added ToV Raid Zones, 3 New Contested Avatars, Arena of the Gods
 *      Added admin menu setting to choose which zones to display
 * V1.1 Initial Release - CoE Raid Zones & Contested Avatars
 */

if ( !defined('EQDKP_INC') ){
	header('HTTP/1.0 404 Not Found');exit;
}

class eq2progress_portal extends portal_generic {
	protected static $path		= 'eq2progress';
	protected static $data		= array(
		'name'			=> 'EQ2 Progression',
		'version'		=> '4.1',
		'author'		=> 'Darkmaeg',
		'contact'		=> EQDKP_PROJECT_URL,
		'description'	=> 'Everquest 2 Progression',
		'multiple'		=> false,
		'lang_prefix'	=> 'eq2progress_'
	);
	protected static $positions = array('middle', 'left1', 'left2', 'right', 'bottom');
	protected static $install	= array(
		'autoenable'		=> '0',
		'defaultposition'	=> 'right',
		'defaultnumber'		=> '7',
	);
	protected static $apiLevel = 20;
	public function get_settings($state) {
			$settings = array(
			'eq2progress_contested'	=> array(
				'name'		=> 'eq2progress_contested',
				'language'	=> 'eq2progress_contested',
				'type'	=> 'radio',
			),	
			'eq2progress_arena'	=> array(
				'name'		=> 'eq2progress_arena',
				'language'	=> 'eq2progress_arena',
				'type'	=> 'radio',
			),	
			'eq2progress_harrows'	=> array(
				'name'		=> 'eq2progress_harrows',
				'language'	=> 'eq2progress_harrows',
				'type'	=> 'radio',
			),
			'eq2progress_sleepers'	=> array(
				'name'		=> 'eq2progress_sleepers',
				'language'	=> 'eq2progress_sleepers',
				'type'	=> 'radio',
			),
			'eq2progress_abhorrence'	=> array(
				'name'		=> 'eq2progress_abhorrence',
				'language'	=> 'eq2progress_abhorrence',
				'type'	=> 'radio',
			),
			'eq2progress_plane'	=> array(
				'name'		=> 'eq2progress_plane',
				'language'	=> 'eq2progress_plane',
				'type'	=> 'radio',
			),
			'eq2progress_dreadcutter'	=> array(
				'name'		=> 'eq2progress_dreadcutter',
				'language'	=> 'eq2progress_dreadcutter',
				'type'	=> 'radio',
			),
			'eq2progress_sirens'	=> array(
				'name'		=> 'eq2progress_sirens',
				'language'	=> 'eq2progress_sirens',
				'type'	=> 'radio',
			),
			'eq2progress_desert'	=> array(
				'name'		=> 'eq2progress_desert',
				'language'	=> 'eq2progress_desert',
				'type'	=> 'radio',
			),
			'eq2progress_veeshan'	=> array(
				'name'		=> 'eq2progress_veeshan',
				'language'	=> 'eq2progress_veeshan',
				'type'	=> 'radio',
			),
			'eq2progress_accursed'	=> array(
				'name'		=> 'eq2progress_accursed',
				'language'	=> 'eq2progress_accursed',
				'type'	=> 'radio',
			),
			'eq2progress_vesspyr'	=> array(
				'name'		=> 'eq2progress_vesspyr',
				'language'	=> 'eq2progress_vesspyr',
				'type'	=> 'radio',
			),
			'eq2progress_kingdom'	=> array(
				'name'		=> 'eq2progress_kingdom',
				'language'	=> 'eq2progress_kingdom',
				'type'	=> 'radio',
			),
			'eq2progress_dreadscale'	=> array(
				'name'		=> 'eq2progress_dreadscale',
				'language'	=> 'eq2progress_dreadscale',
				'type'	=> 'radio',
			),
			'eq2progress_deathtoll'	=> array(
				'name'		=> 'eq2progress_deathtoll',
				'language'	=> 'eq2progress_deathtoll',
				'type'	=> 'radio',
			),
			'eq2progress_agesend'	=> array(
				'name'		=> 'eq2progress_agesend',
				'language'	=> 'eq2progress_agesend',
				'type'	=> 'radio',
			),
			'eq2progress_aomavatar'	=> array(
				'name'		=> 'eq2progress_aomavatar',
				'language'	=> 'eq2progress_aomavatar',
				'type'	=> 'radio',
			),
			'eq2progress_altar1'	=> array(
				'name'		=> 'eq2progress_altar1',
				'language'	=> 'eq2progress_altar1',
				'type'	=> 'radio',
			),
			'eq2progress_altar2'	=> array(
				'name'		=> 'eq2progress_altar2',
				'language'	=> 'eq2progress_altar2',
				'type'	=> 'radio',
			),
			'eq2progress_altar3'	=> array(
				'name'		=> 'eq2progress_altar3',
				'language'	=> 'eq2progress_altar3',
				'type'	=> 'radio',
			),
			'eq2progress_altar4'	=> array(
				'name'		=> 'eq2progress_altar4',
				'language'	=> 'eq2progress_altar4',
				'type'	=> 'radio',
			),
			'eq2progress_altar5'	=> array(
				'name'		=> 'eq2progress_altar5',
				'language'	=> 'eq2progress_altar5',
				'type'	=> 'radio',
			),
			'eq2progress_altar6'	=> array(
				'name'		=> 'eq2progress_altar6',
				'language'	=> 'eq2progress_altar6',
				'type'	=> 'radio',
			),
			'eq2progress_fsdistillery'	=> array(
				'name'		=> 'eq2progress_fsdistillery',
				'language'	=> 'eq2progress_fsdistillery',
				'type'	=> 'radio',
			),
			'eq2progress_freethinkers'	=> array(
				'name'		=> 'eq2progress_freethinkers',
				'language'	=> 'eq2progress_freethinkers',
				'type'	=> 'radio',
			),
			'eq2progress_totcont'	=> array(
				'name'		=> 'eq2progress_totcont',
				'language'	=> 'eq2progress_totcont',
				'type'	=> 'radio',
			),
			'eq2progress_tot1'	=> array(
				'name'		=> 'eq2progress_tot1',
				'language'	=> 'eq2progress_tot1',
				'type'	=> 'radio',
			),
			'eq2progress_tot2'	=> array(
				'name'		=> 'eq2progress_tot2',
				'language'	=> 'eq2progress_tot2',
				'type'	=> 'radio',
			),
			'eq2progress_tot3'	=> array(
				'name'		=> 'eq2progress_tot3',
				'language'	=> 'eq2progress_tot3',
				'type'	=> 'radio',
			),
			'eq2progress_tot4'	=> array(
				'name'		=> 'eq2progress_tot4',
				'language'	=> 'eq2progress_tot4',
				'type'	=> 'radio',
			),
			'eq2progress_tot4'	=> array(
				'name'		=> 'eq2progress_tot4',
				'language'	=> 'eq2progress_tot4',
				'type'	=> 'radio',
			),
			'eq2progress_siege'	=> array(
				'name'		=> 'eq2progress_siege',
				'language'	=> 'eq2progress_siege',
				'type'	=> 'radio',
			),
			'eq2progress_fcazic'	=> array(
				'name'		=> 'eq2progress_fcazic',
				'language'	=> 'eq2progress_fcazic',
				'type'	=> 'radio',
			),
			'eq2progress_ffd'	=> array(
				'name'		=> 'eq2progress_ffd',
				'language'	=> 'eq2progress_ffd',
				'type'	=> 'radio',
			),
			'eq2progress_ka1'	=> array(
				'name'		=> 'eq2progress_ka1',
				'language'	=> 'eq2progress_ka1',
				'type'	=> 'radio',
			),
			'eq2progress_ka2'	=> array(
				'name'		=> 'eq2progress_ka2',
				'language'	=> 'eq2progress_ka2',
				'type'	=> 'radio',
			),
			'eq2progress_ka3'	=> array(
				'name'		=> 'eq2progress_ka3',
				'language'	=> 'eq2progress_ka3',
				'type'	=> 'radio',
			),
			'eq2progress_ka4'	=> array(
				'name'		=> 'eq2progress_ka4',
				'language'	=> 'eq2progress_ka4',
				'type'	=> 'radio',
			),
			'eq2progress_ka5'	=> array(
				'name'		=> 'eq2progress_ka5',
				'language'	=> 'eq2progress_ka5',
				'type'	=> 'radio',
			),
			'eq2progress_ka6'	=> array(
				'name'		=> 'eq2progress_ka6',
				'language'	=> 'eq2progress_ka6',
				'type'	=> 'radio',
			),
			'eq2progress_ka7'	=> array(
				'name'		=> 'eq2progress_ka7',
				'language'	=> 'eq2progress_ka7',
				'type'	=> 'radio',
			),
			'eq2progress_date'	=> array(
				'name'		=> 'eq2progress_date',
				'language'	=> 'eq2progress_date',
				'type'	=> 'radio',
			),
		);
		return $settings;
	}
			
	public function output() {
		if($this->config('eq2progress_headtext')){$this->header = sanitize($this->config('eq2progress_headtext'));}
		$maxbars = 0;
		if (($this->config('eq2progress_contested')) == True ) 		{ ($maxbars = $maxbars + 1); ($zone1 = TRUE); }
		if (($this->config('eq2progress_arena')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone2 = TRUE); }
		if (($this->config('eq2progress_harrows')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone3 = TRUE); }
		if (($this->config('eq2progress_sleepers')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone4 = TRUE); }
		if (($this->config('eq2progress_abhorrence')) == TRUE ) 	{ ($maxbars = $maxbars + 1); ($zone5 = TRUE); }
		if (($this->config('eq2progress_plane')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone6 = TRUE); }
		if (($this->config('eq2progress_dreadcutter')) == TRUE ) 	{ ($maxbars = $maxbars + 1); ($zone7 = TRUE); }
		if (($this->config('eq2progress_sirens')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone8 = TRUE); }
		if (($this->config('eq2progress_desert')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone9 = TRUE); }
		if (($this->config('eq2progress_veeshan')) == TRUE )		{ ($maxbars = $maxbars + 1); ($zone10 = TRUE); }
		if (($this->config('eq2progress_accursed')) == TRUE )		{ ($maxbars = $maxbars + 1); ($zone11 = TRUE); }
		if (($this->config('eq2progress_vesspyr')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone12 = TRUE); }
		if (($this->config('eq2progress_kingdom')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone13 = TRUE); }
		if (($this->config('eq2progress_dreadscale')) == TRUE ) 	{ ($maxbars = $maxbars + 1); ($zone14 = TRUE); }
		if (($this->config('eq2progress_deathtoll')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone15 = TRUE); }
		if (($this->config('eq2progress_agesend')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone16 = TRUE); }
		if (($this->config('eq2progress_aomavatar')) == TRUE )   	{ ($maxbars = $maxbars + 1); ($zone17 = TRUE); }
		if (($this->config('eq2progress_altar1')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone18 = TRUE); }
		if (($this->config('eq2progress_altar2')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone19 = TRUE); }
		if (($this->config('eq2progress_altar3')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone20 = TRUE); }
		if (($this->config('eq2progress_altar4')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone21 = TRUE); }
		if (($this->config('eq2progress_altar5')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone22 = TRUE); }
		if (($this->config('eq2progress_altar6')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone23 = TRUE); }
		if (($this->config('eq2progress_fsdistillery')) == TRUE )	{ ($maxbars = $maxbars + 1); ($zone24 = TRUE); }
		if (($this->config('eq2progress_freethinkers')) == TRUE )	{ ($maxbars = $maxbars + 1); ($zone25 = TRUE); }
		if (($this->config('eq2progress_totcont')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone26 = TRUE); }
		if (($this->config('eq2progress_tot1')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone27 = TRUE); }
		if (($this->config('eq2progress_tot2')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone28 = TRUE); }
		if (($this->config('eq2progress_tot3')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone29 = TRUE); }
		if (($this->config('eq2progress_tot4')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone30 = TRUE); }
		if (($this->config('eq2progress_siege')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone31 = TRUE); }
		if (($this->config('eq2progress_fcazic')) == TRUE )   		{ ($maxbars = $maxbars + 1); ($zone32 = TRUE); }
		if (($this->config('eq2progress_ffd')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone33 = TRUE); }
		if (($this->config('eq2progress_ka1')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone34 = TRUE); }
		if (($this->config('eq2progress_ka2')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone35 = TRUE); }
		if (($this->config('eq2progress_ka3')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone36 = TRUE); }
		if (($this->config('eq2progress_ka4')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone37 = TRUE); }
		if (($this->config('eq2progress_ka5')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone38 = TRUE); }
		if (($this->config('eq2progress_ka6')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone39 = TRUE); }
		if (($this->config('eq2progress_ka7')) == TRUE )   			{ ($maxbars = $maxbars + 1); ($zone40 = TRUE); }
		$arena = 0; $contested = 0; $harrows = 0; $sleeper = 0; $altar = 0; $pow = 0; $dread = 0; $sirens = 0; $djinn= 0;
		$tov = 0; $as = 0; $tovc = 0; $king = 0; $dreadscale = 0; $deathtoll = 0; $agesend = 0; $malice1 = 0; $malice2 = 0; 
		$malice3 = 0; $malice4 = 0; $malice5 = 0; $malice6 = 0; $aoma = 0; $fsd = 0; $eof = 0; $totc = 0; $tot1 = 0; $ffd = 0;
		$tot2 = 0; $tot3 = 0; $tot4 = 0; $siege = 0; $fcazic = 0; $ka1 = 0; $ka2 = 0; $ka3 = 0; $ka4 = 0; $ka5 = 0; $ka6 = 0; $ka7 = 0;
		$arenamax = 10; $contmax = 9; $harrowmax = 12; $sleepermax = 12; $altarmax = 6; $powmax = 7; $dreadmax = 3; $sirenmax = 9; $djinnmax = 2; $eofmax = 8; $tovmax = 15; $asmax = 11; $tovcmax = 2; $kingmax = 3; $dreadscalemax = 8; $deathtollmax = 5; $agesendmax = 4; $malice1max = 4; $malice2max = 3; $malice3max = 3; $malice4max = 5; $malice5max = 5; $malice6max = 3; 
		$aomamax = 5; $fsdmax = 10; $totcmax = 1; $tot1max = 9; $tot2max = 8; $tot3max = 5; $tot4max = 8; $siegemax = 6; $fcazicmax = 1; $ffdmax = 3; $ka1max = 6; $ka2max = 5; $ka3max = 5; $ka4max = 5; $ka5max = 5; $ka6max = 4; $ka7max = 1;
		$this->game->new_object('eq2_daybreak', 'daybreak', array($this->config->get('uc_server_loc'), $this->config->get('uc_data_lang')));
		if(!is_object($this->game->obj['daybreak'])) return "";
		$guilddata = $this->game->obj['daybreak']->guildinfo($this->config->get('guildtag'), $this->config->get('servername'), false);
		$achieve = $guilddata['guild_list'][0]['achievement_list'];	
		$gdata 	  = $guilddata['guild_list'][0];
		$ktot = count($achieve);
		$spacer = ""; 
		if (($this->config('eq2progress_date')) == TRUE ) 		{ ($spacer = "Not Killed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"); }
		$cval=$this->user->lang('eq2progress_f_eq2progress_contested');
		$c1=$spacer.'<font color="white">Vallon Zek</font><br>'; $c2=$spacer.'<font color="white">Tallon Zek</font><br>';		
		$c3=$spacer.'<font color="white">Sullon Zek</font><br>'; $c4=$spacer.'<font color="white">Rodcet Nife</font><br>';		
		$c5=$spacer.'<font color="white">Mithaniel Marr</font><br>'; $c6=$spacer.'<font color="white">Tunare</font><br>';
		$c7=$spacer.'<font color="white">Prexus</font><br>'; $c8=$spacer.'<font color="white">Solusek Ro</font><br>';
		$c9=$spacer.'<font color="white">Drinal</font><br>';
		$arval=$this->user->lang('eq2progress_f_eq2progress_arena');
		$ar1=$spacer.'<font color="white">Vallon Zek</font><br>'; $ar2=$spacer.'<font color="white">Tallon Zek</font><br>';		
		$ar3=$spacer.'<font color="white">Sullon Zek</font><br>'; $ar4=$spacer.'<font color="white">Rodcet Nife</font><br>';		
		$ar5=$spacer.'<font color="white">Mithaniel Marr</font><br>'; $ar6=$spacer.'<font color="white">Tunare</font><br>';
		$ar7=$spacer.'<font color="white">Prexus</font><br>'; $ar8=$spacer.'<font color="white">Solusek Ro</font><br>';
		$ar9=$spacer.'<font color="white">Drinal</font><br>'; $ar10=$spacer.'<font color="white">Bristlebane</font><br>';
		$hval=$this->user->lang('eq2progress_f_eq2progress_harrows');
		$h1=$spacer.'<font color="white">Drinal 4 Soulwells</font><br>'; $h2=$spacer.'<font color="white">Drinal 3 Soulwells</font><br>';
		$h3=$spacer.'<font color="white">Drinal 2 Soulwells</font><br>'; $h4=$spacer.'<font color="white">Drinal 1 Soulwell</font><br>';
		$h5=$spacer.'<font color="white">Oligar of the Dead Challenge</font><br>'; $h6=$spacer.'<font color="white">Oligar of the Dead</font><br>';		
		$h7=$spacer.'<font color="white">Fitzpitzle</font><br>'; $h8=$spacer.'<font color="white">Bastion Challenge</font><br>';		
		$h9=$spacer.'<font color="white">Bastion</font><br>'; $h10=$spacer.'<font color="white">Construct of Souls</font><br>';		
		$h11=$spacer.'<font color="white">Melanie Everling</font><br>';	$h12=$spacer.'<font color="white">Caerina the Lost</font><br>';	
		$slval=$this->user->lang('eq2progress_f_eq2progress_sleepers');
		$sl1=$spacer.'<font color="white">Amalgamon Challenge</font><br>'; $sl2=$spacer.'<font color="white">Eidolon the Hraashna</font><br>';
		$sl3=$spacer.'<font color="white">Eidolon the Tukaarak</font><br>';	$sl4=$spacer.'<font color="white">Eidolon the Nanzata</font><br>';
		$sl5=$spacer.'<font color="white">Eidolon the Ventani</font><br>'; $sl6=$spacer.'<font color="white">Ancient Sentinel Challenge</font><br>';	
		$sl7=$spacer.'<font color="white">Ancient Sentinel</font><br>'; $sl8=$spacer.'<font color="white">Drels Ma\'Gor</font><br>';	
		$sl9=$spacer.'<font color="white">Mazarine The Queen</font><br>'; $sl10=$spacer.'<font color="white">Sorrn Dontro</font><br>';	
		$sl11=$spacer.'<font color="white">Silis On\'va</font><br>'; $sl12=$spacer.'<font color="white">Gloust M\'ra</font><br>';	
		$aval=$this->user->lang('eq2progress_f_eq2progress_abhorrence');
		$a1=$spacer.'<font color="white">Baroddas and Baelon Challenge</font><br>'; $a2=$spacer.'<font color="white">Baroddas</font><br>';		
		$a3=$spacer.'<font color="white">Sarinich the Wretched</font><br>'; $a4=$spacer.'<font color="white">Pharinich the Forelorn</font><br>';		
		$a5=$spacer.'<font color="white">The Enraged Imp</font><br>'; $a6=$spacer.'<font color="white">The Fear Feaster</font><br>';	
		$pval=$this->user->lang('eq2progress_f_eq2progress_plane');
		$p1=$spacer.'<font color="white">General Teku</font><br>'; $p2=$spacer.'<font color="white">Corpsemaul and Goreslaughter</font><br>';		
		$p3=$spacer.'<font color="white">Eriak the Fetid</font><br>'; $p4=$spacer.'<font color="white">Glokus Windhelm</font><br>';		
		$p5=$spacer.'<font color="white">Tagrin Maldric</font><br>'; $p6=$spacer.'<font color="white">Berik Bloodfist</font><br>';
		$p7=$spacer.'<font color="white">The Enraged War Boar</font><br>';	 
		$dval=$this->user->lang('eq2progress_f_eq2progress_dreadcutter');
		$d1=$spacer.'<font color="white">Omugra, Thazurus, & Vuzalg</font><br>';
		$d2=$spacer.'<font color="white">Tuzerk</font><br>'; $d3=$spacer.'<font color="white">Zzalazziz</font><br>';		
		$srval=$this->user->lang('eq2progress_f_eq2progress_sirens');
		$sr1=$spacer.'<font color="white">Psyllon\'Ris Challenge</font><br>'; $sr2=$spacer.'<font color="white">Overlord Talan Challenge</font><br>';	
		$sr3=$spacer.'<font color="white">Overlord Talan</font><br>'; $sr4=$spacer.'<font color="white">Diviner Gelerin</font><br>';	
		$sr5=$spacer.'<font color="white">Gen\'ra Challenge</font><br>'; $sr6=$spacer.'<font color="white">Gen\'ra</font><br>';
		$sr7=$spacer.'<font color="white">Priestess Denerva Vah\'lis</font><br>'; $sr8=$spacer.'<font color="white">Entrancer Lisha</font><br>';
		$sr9=$spacer.'<font color="white">Caella of the Pearl</font><br>';
		$djval=$this->user->lang('eq2progress_f_eq2progress_desert');
		$dj1=$spacer.'<font color="white">Djinn Master</font><br>'; $dj2=$spacer.'<font color="white">Barakah & Siyamak</font><br>';
		$tovval=$this->user->lang('eq2progress_f_eq2progress_veeshan'); 
		$tov1=$spacer.'<font color="white">Zlandicar The Consumer of Bones</font><br>'; $tov2=$spacer.'<font color="white">Klandicar</font><br>'; 
		$tov3=$spacer.'<font color="white">Controller Ervin and Pyrelord Kullis</font><br>'; $tov4=$spacer.'<font color="white">Gerid, Harin, and Merig</font><br>';
		$tov5=$spacer.'<font color="white">Jardin the Conqueror</font><br>'; $tov6=$spacer.'<font color="white">Andreis the Culler</font><br>'; 
		$tov7=$spacer.'<font color="white">The Aerakyn Commanders</font><br>'; $tov8=$spacer.'<font color="white">Grendish</font><br>'; 
		$tov9=$spacer.'<font color="white">Tavekalem</font><br>'; $tov10=$spacer.'<font color="white">Derig the Prime Executioner</font><br>'; 
		$tov11=$spacer.'<font color="white">Kigara the Blazewing and Kelana the Frostwing</font><br>'; $tov12=$spacer.'<font color="white">Rarthek the Swiftwing</font><br>'; 
		$tov13=$spacer.'<font color="white">Caden and Keplin</font><br>'; $tov14=$spacer.'<font color="white">Essedara and Jalkhir</font><br>'; 
		$tov15=$spacer.'<font color="white">Sontalak</font><br>';
		$asval=$this->user->lang('eq2progress_f_eq2progress_accursed'); 
		$as1=$spacer.'<font color="white">The Crumbling Emperor</font><br>'; $as2=$spacer.'<font color="white">Matri Marn</font><br>';
		$as3=$spacer.'<font color="white">Sacrificer Buran</font><br>'; $as4=$spacer.'<font color="white">The Legionnaires</font><br>';
		$as5=$spacer.'<font color="white">Sesria and Denani</font><br>'; $as6=$spacer.'<font color="white">The Protector of Stone</font><br>';
		$as7=$spacer.'<font color="white">Kaasssrelik the Afflicted</font><br>'; $as8=$spacer.'<font color="white">Subsistent Custodian</font><br>';
		$as9=$spacer.'<font color="white">Adherant Custodian</font><br>'; $as10=$spacer.'<font color="white">Ageless Custodian</font><br>';
		$as11=$spacer.'<font color="white">Accursed Custodian</font><br>';
		$tovcval=$this->user->lang('eq2progress_f_eq2progress_vesspyr');
		$tovc1=$spacer.'<font color="white">Draazak the Ancient</font><br>';$tovc2=$spacer.'<font color="white">Exarch Lorokai the Unliving</font><br>';
		$kingval=$this->user->lang('eq2progress_f_eq2progress_kingdom');
		$king1=$spacer.'<font color="white">Lord Vyemm</font><br>';$king2=$spacer.'<font color="white">Mutagenic Outcast</font><br>';
		$king3=$spacer.'<font color="white">Three Princes</font><br>';
		$dreadscaleval=$this->user->lang('eq2progress_f_eq2progress_dreadscale');
		$dreadscale1=$spacer.'<font color="white">Bristlebane</font><br>';$dreadscale2=$spacer.'<font color="white">Vulak\'Aerr the Dreadscale</font><br>';
		$dreadscale3=$spacer.'<font color="white">Telkorenar</font><br>';$dreadscale4=$spacer.'<font color="white">Irdul of the Glacier</font><br>';
		$dreadscale5=$spacer.'<font color="white">Lord Kriezenn</font><br>';$dreadscale6=$spacer.'<font color="white">Lord Feshlak</font><br>';
		$dreadscale7=$spacer.'<font color="white">Lady Mirenella</font><br>';$dreadscale8=$spacer.'<font color="white">Cer\'matal the Gatekeeper</font><br>';
		$deathtollval=$this->user->lang('eq2progress_f_eq2progress_deathtoll');
		$deathtoll1=$spacer.'<font color="white">Tarinax the Destroyer</font><br>';$deathtoll2=$spacer.'<font color="white">Cruor Alluvium</font><br>';
		$deathtoll3=$spacer.'<font color="white">Amorphous Drake</font><br>';$deathtoll4=$spacer.'<font color="white">Fitzpitzle</font><br>';
		$deathtoll5=$spacer.'<font color="white">Yitzik the Hurler</font><br>';
		$agesendval=$this->user->lang('eq2progress_f_eq2progress_agesend');
		$agesend1=$spacer.'<font color="white">General Velryyn (Challenge)</font><br>';$agesend2=$spacer.'<font color="white">Roehn Theer (Challenge)</font><br>';
		$agesend3=$spacer.'<font color="white">General Velryyn</font><br>';$agesend4=$spacer.'<font color="white">Roehn Theer</font><br>';
		$malice1val=$this->user->lang('eq2progress_f_eq2progress_altar1'); 
		$malice11=$spacer.'<font color="white">Perador the Mighty</font><br>'; $malice12=$spacer.'<font color="white">The Crumbling Icon</font><br>';
		$malice13=$spacer.'<font color="white">Kerridicus Searskin</font><br>'; $malice14=$spacer.'<font color="white">Teraradus the Gorer</font><br>';
		$malice2val=$this->user->lang('eq2progress_f_eq2progress_altar2'); $malice21=$spacer.'<font color="white">Grethah the Frenzied</font><br>'; 
		$malice22=$spacer.'<font color="white">Zebrun the Torso</font><br>'; $malice23=$spacer.'<font color="white">Grevog the Punisher</font><br>'; 
		$malice3val=$this->user->lang('eq2progress_f_eq2progress_altar3');
		$malice31=$spacer.'<font color="white">Captain Krasnok</font><br>'; 
		$malice32=$spacer.'<font color="white">Jessip Daggerheart</font><br>'; 
		$malice33=$spacer.'<font color="white">Swindler and the Brute</font><br>'; 
		$malice4val=$this->user->lang('eq2progress_f_eq2progress_altar4');
		$malice41=$spacer.'<font color="white">Arch Lich Rhag\'Zadune</font><br>'; $malice42=$spacer.'<font color="white">Ka\'Rah Ferun</font><br>';
		$malice43=$spacer.'<font color="white">Diabo, Va, and Centi Kela\'Set</font><br>'; $malice44=$spacer.'<font color="white">Farozth Ssravizh</font><br>'; 
		$malice45=$spacer.'<font color="white">Gomrim, Zwebek, Tonnin, and Yermon</font><br>'; 
		$malice5val=$this->user->lang('eq2progress_f_eq2progress_altar5');
		$malice51=$spacer.'<font color="white">Primordial Ritualist Villandre V\'Zher</font><br>'; $malice52=$spacer.'<font color="white">Protector of Bones</font><br>'; 
		$malice53=$spacer.'<font color="white">Virtuoso Edgar V\'Zann</font><br>'; $malice54=$spacer.'<font color="white">Sacrificer Aevila D\'Serin</font><br>'; 
		$malice55=$spacer.'<font color="white">Inquisitor Soronigus</font><br>'; 
		$malice6val=$this->user->lang('eq2progress_f_eq2progress_altar6');
		$malice61=$spacer.'<font color="white">Construct of Malice</font><br>'; $malice62=$spacer.'<font color="white">Tserrina Syl\'tor</font><br>'; 
		$malice63=$spacer.'<font color="white">Ritual Keeper V\'derin</font><br>'; 
		$aomaval=$this->user->lang('eq2progress_f_eq2progress_aomavatar');
		$aoma1=$spacer.'<font color="white">Brell Serilis</font><br>'; $aoma2=$spacer.'<font color="white">Cazic-Thule</font><br>'; 
		$aoma3=$spacer.'<font color="white">Fennin Ro</font><br>'; $aoma4=$spacer.'<font color="white">Karana</font><br>'; 
		$aoma5=$spacer.'<font color="white">The Tribunal</font><br>';
		$fsdval=$this->user->lang('eq2progress_f_eq2progress_fsdistillery');
		$fsd1=$spacer.'<font color="white">Baz the Illusionist</font><br>'; $fsd2=$spacer.'<font color="white">Danacio the Witchdoctor</font><br>'; $fsd3=$spacer.'<font color="white">Brunhildre the Wench</font><br>'; 
		$fsd4=$spacer.'<font color="white">Pirate Shaman Snaggletooth</font><br>'; $fsd5=$spacer.'<font color="white">Kildiun the Drunkard</font><br>'; $fsd6=$spacer.'<font color="white">Charanda</font><br>'; $fsd7=$spacer.'<font color="white">Bull McCleran</font><br>'; $fsd8=$spacer.'<font color="white">Swabber Rotgut</font><br>'; $fsd9=$spacer.'<font color="white">Captain Mergin</font><br>'; $fsd10=$spacer.'<font color="white">Brutas the Imbiber</font><br>'; 
		$eofval=$this->user->lang('eq2progress_f_eq2progress_freethinkers');
		$eof1=$spacer.'<font color="white">Malkonis D\'Morte (Challenge)</font><br>'; $eof2=$spacer.'<font color="white">Treyloth D\'Kulvith (Challenge)</font><br>'; 
		$eof3=$spacer.'<font color="white">Othysis Muravian (Challenge)</font><br>'; $eof4=$spacer.'<font color="white">Zylphax the Shredder (Challenge)</font><br>'; 
		$eof5=$spacer.'<font color="white">Malkonis D\'Morte</font><br>'; $eof6=$spacer.'<font color="white">Treyloth D\'Kulvith</font><br>';
		$eof7=$spacer.'<font color="white">Othysis Muravian</font><br>'; $eof8=$spacer.'<font color="white">Zylphax the Shredder</font><br>';
		$totcval=$this->user->lang('eq2progress_f_eq2progress_totcont'); 
		$totc1=$spacer.'<font color="white">Vanlith the Mysterious One</font><br>'; 
		$totc2=$spacer.'<font color="white">Venekor</font><br>'; 
		$tot1val=$this->user->lang('eq2progress_f_eq2progress_tot1');
		$tot11=$spacer.'<font color="white">Bhoughbh Nova-Prime</font><br>'; $tot12=$spacer.'<font color="white">MCP-Powered Pulsar</font><br>'; 
		$tot13=$spacer.'<font color="white">The Tinkered Abomination</font><br>'; $tot14=$spacer.'<font color="white">Hovercopter Hingebot</font><br>'; 
		$tot15=$spacer.'<font color="white">The Malfunctioning Slaver</font><br>'; $tot16=$spacer.'<font color="white">Electroshock Grinder VIII</font><br>';
		$tot17=$spacer.'<font color="white">Sentinel XXI</font><br>'; $tot18=$spacer.'<font color="white">Short-Circuited Construct Bot</font><br>'; $tot19=$spacer.'<font color="white">Bhoughbh Model XVII</font><br>';
		$tot2val=$this->user->lang('eq2progress_f_eq2progress_tot2');
		$tot21=$spacer.'<font color="white">Kyrus of the Old Ways</font><br>'; $tot22=$spacer.'<font color="white">The Forge Golem</font><br>'; 
		$tot23=$spacer.'<font color="white">Captain Ashenfell</font><br>'; $tot24=$spacer.'<font color="white">Captain Graybeard</font><br>'; 
		$tot25=$spacer.'<font color="white">Uigirf, Htardlem, and Omzzem</font><br>'; $tot26=$spacer.'<font color="white">Bereth Mathias</font><br>';
		$tot27=$spacer.'<font color="white">Kiernun the Lyrical</font><br>'; $tot28=$spacer.'<font color="white">Cronnin & Dellmun</font><br>';
		$tot3val=$this->user->lang('eq2progress_f_eq2progress_tot3');
		$tot31=$spacer.'<font color="white">Iron Forged Constructs</font><br>'; $tot32=$spacer.'<font color="white">Jorik the Scourge</font><br>'; 
		$tot33=$spacer.'<font color="white">Crohp the Mighty</font><br>'; $tot34=$spacer.'<font color="white">King Lockt</font><br>'; 
		$tot35=$spacer.'<font color="white">Wedge Tinderton</font><br>';
		$tot4val=$this->user->lang('eq2progress_f_eq2progress_tot4');
		$tot41=$spacer.'<font color="white">Kraletus</font><br>'; $tot42=$spacer.'<font color="white">Ynonngozzz\'Koolbh</font><br>'; $tot43=$spacer.'<font color="white">The Polliwog</font><br>'; $tot44=$spacer.'<font color="white">Sath\'Oprusk</font><br>'; 
		$tot45=$spacer.'<font color="white">The Psionists</font><br>'; $tot46=$spacer.'<font color="white">Ojuti the Vile</font><br>'; $tot47=$spacer.'<font color="white">Karith\'Ta</font><br>'; $tot48=$spacer.'<font color="white">Charrid the Mindwarper</font><br>';
		$siegeval=$this->user->lang('eq2progress_f_eq2progress_siege'); 
		$siege1=$spacer.'<font color="white">The Weapon of War</font><br>'; $siege2=$spacer.'<font color="white">Sanctifier Goortuk Challenge Mode</font><br>'; 
		$siege3=$spacer.'<font color="white">Sanctifier Goortuk</font><br>'; $siege4=$spacer.'<font color="white">Durtung the Arm of War</font><br>'; 
		$siege5=$spacer.'<font color="white">Kreelit, Caller of Hounds</font><br>'; $siege6=$spacer.'<font color="white">Fergul the Protector</font><br>';
		$fcazicval=$this->user->lang('eq2progress_f_eq2progress_fcazic'); 
		$fcazic1=$spacer.'<font color="white">Fabled Venekor</font><br>';
		$ffdval=$this->user->lang('eq2progress_f_eq2progress_ffd'); 
		$ffd1=$spacer.'<font color="white">Fabled Chel\'Drak</font><br>';
		$ffd2=$spacer.'<font color="white">Fabled Xux\'laio</font><br>';
		$ffd3=$spacer.'<font color="white">Fabled Bonesnapper</font><br>';
		$ka1val=$this->user->lang('eq2progress_f_eq2progress_ka1');
		$ka11=$spacer.'<font color="white">Shanaira the Prestigious</font><br>';
		$ka12=$spacer.'<font color="white">Amalgams of Order and Chaos</font><br>';
		$ka13=$spacer.'<font color="white">Shanaira the Powermonger</font><br>';
		$ka14=$spacer.'<font color="white">Botanist Heridal</font><br>';
		$ka15=$spacer.'<font color="white">Guardian of Arcanna\'se</font><br>';
		$ka16=$spacer.'<font color="white">Memory of the Stolen</font><br>';
		$ka2val=$this->user->lang('eq2progress_f_eq2progress_ka2');
		$ka21=$spacer.'<font color="white">Xalgoz</font><br>';
		$ka22=$spacer.'<font color="white">Sentinel Primatious</font><br>';
		$ka23=$spacer.'<font color="white">Strathbone Runelord</font><br>';
		$ka24=$spacer.'<font color="white">Chomp</font><br>';
		$ka25=$spacer.'<font color="white">Valigez, the Entomber</font><br>';
		$ka3val=$this->user->lang('eq2progress_f_eq2progress_ka3');
		$ka31=$spacer.'<font color="white">The Kly</font><br>';
		$ka32=$spacer.'<font color="white">Gorius the Gray</font><br>';
		$ka33=$spacer.'<font color="white">Brutius the Skulk</font><br>';
		$ka34=$spacer.'<font color="white">Danariun, the Crypt Keeper</font><br>';
		$ka35=$spacer.'<font color="white">Lumpy Goo</font><br>';
		$ka4val=$this->user->lang('eq2progress_f_eq2progress_ka4');
		$ka41=$spacer.'<font color="white">Lord Rak\'Ashiir</font><br>';
		$ka42=$spacer.'<font color="white">Lord Ghiosk</font><br>';
		$ka43=$spacer.'<font color="white">The Black Reaver</font><br>';
		$ka44=$spacer.'<font color="white">The Captain of the Guard</font><br>';
		$ka45=$spacer.'<font color="white">Gyrating Green Slime</font><br>';
		$ka5val=$this->user->lang('eq2progress_f_eq2progress_ka5');
		$ka51=$spacer.'<font color="white">Setri Lureth</font><br>';
		$ka52=$spacer.'<font color="white">Raenha, Sister of Remorse</font><br>';
		$ka53=$spacer.'<font color="white">Vhaksiz the Shade</font><br>';
		$ka54=$spacer.'<font color="white">Anaheed the Dreamkeeper</font><br>';
		$ka55=$spacer.'<font color="white">Hobgoblin Anguish Lord</font><br>';
		$ka6val=$this->user->lang('eq2progress_f_eq2progress_ka6');
		$ka62=$spacer.'<font color="white">Territus, the Deathbringer</font><br>';
		$ka63=$spacer.'<font color="white">Baliath, Harbinger of Nightmares</font><br>';
		$ka64=$spacer.'<font color="white">The Summoned foes</font><br>';
		$ka61=$spacer.'<font color="white">Warden of Nightmares</font><br>';
		$ka7val=$this->user->lang('eq2progress_f_eq2progress_ka7');
		$ka71=$spacer.'<font color="white">The Rejuvenating One</font><br>';
		//Check which have been killed
		$killslist = $this->pdc->get('portal.module.eq2progress.'.$this->root_path);
				if (!$killslist){
		for ($a=0; $a<=$ktot; $a++) {
		$kdate = "";
		if (($this->config('eq2progress_date')) == TRUE ) 		
		{ ($stamp = date('m/d/Y', $achieve[$a]['completedtimestamp'])); 
        ($kdate = '<font color="white">'.$stamp.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>'); }
		$acid = $achieve[$a]['id'];
		//Dreadcutter
		if ($acid == '3473349988') {$dread = $dread + 1; $d1 =$kdate.'<font color="808080"><strike>Omugra, Thazurus, & Vuzalg</strike></font><br>';} 
		if ($acid == '4032221026') {$dread = $dread + 1; $d2 =$kdate.'<font color="808080"><strike>Tuzerk</strike></font><br>';} 
		if ($acid == '1147209950') {$dread = $dread + 1; $d3 =$kdate.'<font color="808080"><strike>Zzalazziz</strike></font><br>';} 
		//Contested
		if ($acid == '4101909069') {$contested = $contested + 1; $c1 =$kdate.'<font color="808080"><strike>Vallon Zek</strike></font><br>';} 
		if ($acid == '4035705456') {$contested = $contested + 1; $c2 =$kdate.'<font color="808080"><strike>Tallon Zek</strike></font><br>';} 
		if ($acid == '3816551028') {$contested = $contested + 1; $c3 =$kdate.'<font color="808080"><strike>Sullon Zek</strike></font><br>';} 
		if ($acid == '2623216647') {$contested = $contested + 1; $c4 =$kdate.'<font color="808080"><strike>Rodcet Nife</strike></font><br>';} 
		if ($acid == '42226058')   {$contested = $contested + 1; $c5 =$kdate.'<font color="808080"><strike>Mithaniel Marr</strike></font><br>';} 
		if ($acid == '2942232089') {$contested = $contested + 1; $c6 =$kdate.'<font color="808080"><strike>Tunare</strike></font><br>';} 
		if ($acid == '4186719351') {$contested = $contested + 1; $c7 =$kdate.'<font color="808080"><strike>Prexus</strike></font><br>';} 
		if ($acid == '1748417285') {$contested = $contested + 1; $c8 =$kdate.'<font color="808080"><strike>Solusek Ro</strike></font><br>';} 
		if ($acid == '2417016352') {$contested = $contested + 1; $c9 =$kdate.'<font color="808080"><strike>Drinal</strike></font><br>';} 
		//Arena of the Gods
		if ($acid == '3620327620') {$arena = $arena + 1; $ar1 =$kdate.'<font color="808080"><strike>Vallon Zek</strike></font><br>';} 
		if ($acid == '3543924985') {$arena = $arena + 1; $ar2 =$kdate.'<font color="808080"><strike>Tallon Zek</strike></font><br>';} 
		if ($acid == '3234597117') {$arena = $arena + 1; $ar3 =$kdate.'<font color="808080"><strike>Sullon Zek</strike></font><br>';} 
		if ($acid == '136089721')  {$arena = $arena + 1; $ar4 =$kdate.'<font color="808080"><strike>Rodcet Nife</strike></font><br>';} 
		if ($acid == '593827632')  {$arena = $arena + 1; $ar5 =$kdate.'<font color="808080"><strike>Mithaniel Marr</strike></font><br>';} 
		if ($acid == '1253692288') {$arena = $arena + 1; $ar6 =$kdate.'<font color="808080"><strike>Tunare</strike></font><br>';} 
		if ($acid == '476803566')  {$arena = $arena + 1; $ar7 =$kdate.'<font color="808080"><strike>Prexus</strike></font><br>';} 
		if ($acid == '1266762124') {$arena = $arena + 1; $ar8 =$kdate.'<font color="808080"><strike>Solusek Ro</strike></font><br>';} 
		if ($acid == '1979157433') {$arena = $arena + 1; $ar9 =$kdate.'<font color="808080"><strike>Drinal</strike></font><br>';}
		if ($acid == '2968476469') {$arena = $arena + 1; $ar10 =$kdate.'<font color="808080"><strike>Bristlebane</strike></font><br>';}
		//Altar
		if ($acid == '2815791137') {$altar = $altar + 1; $a1 =$kdate.'<font color="808080"><strike>Baroddas and Baelon Challenge</strike></font><br>';} 
		if ($acid == '556664517')  {$altar = $altar + 1; $a2 =$kdate.'<font color="808080"><strike>Baroddas</strike></font><br>';} 
		if ($acid == '3242793609') {$altar = $altar + 1; $a3 =$kdate.'<font color="808080"><strike>Sarinich the Wretched</strike></font><br>';} 
		if ($acid == '264073381')  {$altar = $altar + 1; $a4 =$kdate.'<font color="808080"><strike>Pharinich the Forelorn</strike></font><br>';} 
		if ($acid == '3484573768') {$altar = $altar + 1; $a5 =$kdate.'<font color="808080"><strike>The Enraged Imp</strike></font><br>';} 
		if ($acid == '2746803668') {$altar = $altar + 1; $a6 =$kdate.'<font color="808080"><strike>The Fear Feaster</strike></font><br>';} 
		//PoW
		if ($acid == '3615452988') {$pow = $pow + 1; $p1 =$kdate.'<font color="808080"><strike>General Teku</strike></font><br>';} 
		if ($acid == '106169668')  {$pow = $pow + 1; $p2 =$kdate.'<font color="808080"><strike>Corpsemaul and Goreslaughter</strike></font><br>';} 
		if ($acid == '1816962692') {$pow = $pow + 1; $p3 =$kdate.'<font color="808080"><strike>Eriak the Fetid</strike></font><br>';} 
		if ($acid == '3247251751') {$pow = $pow + 1; $p4 =$kdate.'<font color="808080"><strike>Glokus Windhelm</strike></font><br>';} 
		if ($acid == '2004193543') {$pow = $pow + 1; $p5 =$kdate.'<font color="808080"><strike>Tagrin Maldric</strike></font><br>';} 
		if ($acid == '185935404')  {$pow = $pow + 1; $p6 =$kdate.'<font color="808080"><strike>Berik Bloodfist</strike></font><br>';} 
		if ($acid == '1846185861') {$pow = $pow + 1; $p7 =$kdate.'<font color="808080"><strike>The Enraged War Boar</strike></font><br>';} 
		//Harrows
		if ($acid == '117381414')  {$harrows = $harrows + 1; $h1 =$kdate.'<font color="808080"><strike>Drinal 4 Soulwells</strike></font><br>';} 
		if ($acid == '2560330885') {$harrows = $harrows + 1; $h2 =$kdate.'<font color="808080"><strike>Drinal 3 Soulwells</strike></font><br>';} 
		if ($acid == '4020026387') {$harrows = $harrows + 1; $h3 =$kdate.'<font color="808080"><strike>Drinal 2 Soulwells</strike></font><br>';} 
		if ($acid == '1989537193') {$harrows = $harrows + 1; $h4 =$kdate.'<font color="808080"><strike>Drinal 1 Soulwells</strike></font><br>';} 
		if ($acid == '1185436638') {$harrows = $harrows + 1; $h5 =$kdate.'<font color="808080"><strike>Oligar of the Dead Challenge</strike></font><br>';} 
		if ($acid == '157673149')  {$harrows = $harrows + 1; $h6 =$kdate.'<font color="808080"><strike>Oligar of the Dead</strike></font><br>';} 
		if ($acid == '3792025342') {$harrows = $harrows + 1; $h7 =$kdate.'<font color="808080"><strike>Fitzpitzle</strike></font><br>';}
		if ($acid == '907757996')  {$harrows = $harrows + 1; $h8 =$kdate.'<font color="808080"><strike>Bastion Challenge</strike></font><br>';} 
		if ($acid == '1528421984') {$harrows = $harrows + 1; $h9 =$kdate.'<font color="808080"><strike>Bastion</strike></font><br>';}
		if ($acid == '2492675577') {$harrows = $harrows + 1; $h10 =$kdate.'<font color="808080"><strike>Construct of Souls</strike></font><br>';}
		if ($acid == '1568891259') {$harrows = $harrows + 1; $h11 =$kdate.'<font color="808080"><strike>Melanie Everling</strike></font><br>';}
		if ($acid == '3310417778') {$harrows = $harrows + 1; $h12 =$kdate.'<font color="808080"><strike>Caerina the Lost</strike></font><br>';}
		//Sleeper
		if ($acid == '1622583242') {$sleeper = $sleeper + 1; $sl1 =$kdate.'<font color="808080"><strike>Amalgamon Challenge</strike></font><br>';} 
		if ($acid == '1818208719') {$sleeper = $sleeper + 1; $sl2 =$kdate.'<font color="808080"><strike>Eidolon the Hraashna</strike></font><br>';} 
		if ($acid == '2946227232') {$sleeper = $sleeper + 1; $sl3 =$kdate.'<font color="808080"><strike>Eidolon the Tukaarak</strike></font><br>';} 
		if ($acid == '3549173671') {$sleeper = $sleeper + 1; $sl4 =$kdate.'<font color="808080"><strike>Eidolon the Nanzata</strike></font><br>';} 
		if ($acid == '1107657410') {$sleeper = $sleeper + 1; $sl5 =$kdate.'<font color="808080"><strike>Eidolon the Ventani</strike></font><br>';} 
		if ($acid == '4257512634') {$sleeper = $sleeper + 1; $sl6 =$kdate.'<font color="808080"><strike>Ancient Sentinel Challenge</strike></font><br>';} 
		if ($acid == '4157961701') {$sleeper = $sleeper + 1; $sl7 =$kdate.'<font color="808080"><strike>Ancient Sentinel</strike></font><br>';}
		if ($acid == '2637741014') {$sleeper = $sleeper + 1; $sl8 =$kdate.'<font color="808080"><strike>Drels Ma\'Gor</strike></font><br>';} 
		if ($acid == '1273574905') {$sleeper = $sleeper + 1; $sl9 =$kdate.'<font color="808080"><strike>Mazarine The Queen</strike></font><br>';}
		if ($acid == '474510614')  {$sleeper = $sleeper + 1; $sl10 =$kdate.'<font color="808080"><strike>Sorrn Dontro</strike></font><br>';}
		if ($acid == '1500023527') {$sleeper = $sleeper + 1; $sl11 =$kdate.'<font color="808080"><strike>Silis On\'va</strike></font><br>';} 
		if ($acid == '861635210')  {$sleeper = $sleeper + 1; $sl12 =$kdate.'<font color="808080"><strike>Gloust M\'ra</strike></font><br>';}
		//Sirens
		if ($acid == '835180705')  {$sirens = $sirens + 1; $sr1 =$kdate.'<font color="808080"><strike>Psyllon\'Ris Challenge</strike></font><br>';} 
		if ($acid == '1529512366') {$sirens = $sirens + 1; $sr2 =$kdate.'<font color="808080"><strike>Overlord Talan Challenge</strike></font><br>';} 
		if ($acid == '993709817')  {$sirens = $sirens + 1; $sr3 =$kdate.'<font color="808080"><strike>Overlord Talan</strike></font><br>';} 
		if ($acid == '3834891606') {$sirens = $sirens + 1; $sr4 =$kdate.'<font color="808080"><strike>Diviner Gelerin</strike></font><br>';} 
		if ($acid == '3434949318') {$sirens = $sirens + 1; $sr5 =$kdate.'<font color="808080"><strike>Gen\'ra Challenge</strike></font><br>';} 
		if ($acid == '2765038209') {$sirens = $sirens + 1; $sr6 =$kdate.'<font color="808080"><strike>Gen\'ra</strike></font><br>';} 
		if ($acid == '844140861')  {$sirens = $sirens + 1; $sr7 =$kdate.'<font color="808080"><strike>Priestess Denerva Vah\'lis</strike></font><br>';}
		if ($acid == '3010082956') {$sirens = $sirens + 1; $sr8 =$kdate.'<font color="808080"><strike>Entrancer Lisha</strike></font><br>';} 
		if ($acid == '966685891')  {$sirens = $sirens + 1; $sr9 =$kdate.'<font color="808080"><strike>Caella of the Pearl</strike></font><br>';}
		//Djinn's Master - Fabled Version
		if ($acid == '725611006')  {$djinn = $djinn + 1; $dj1 =$kdate.'<font color="808080"><strike>Djinn Master</strike></font><br>';} 
		if ($acid == '4166546610') {$djinn = $djinn + 1; $dj2 =$kdate.'<font color="808080"><strike>Barakah & Siyamak</strike></font><br>';} 
		//Temple of Veeshan
		if ($acid == '616943266')  {$tov = $tov + 1; $tov1 =$kdate.'<font color="808080"><strike>Zlandicar The Consumer of Bones</strike></font><br>';}
		if ($acid == '1592805200') {$tov = $tov + 1; $tov2 =$kdate.'<font color="808080"><strike>Klandicar</strike></font><br>';}
		if ($acid == '3274528803') {$tov = $tov + 1; $tov3 =$kdate.'<font color="808080"><strike>Controller Ervin and Pyrelord Kullis</strike></font><br>';}
		if ($acid == '277519507')  {$tov = $tov + 1; $tov4 =$kdate.'<font color="808080"><strike>Gerid, Harin, and Merig</strike></font><br>';}
		if ($acid == '1291367636') {$tov = $tov + 1; $tov5 =$kdate.'<font color="808080"><strike>Jardin the Conqueror</strike></font><br>';}
		if ($acid == '1588269527') {$tov = $tov + 1; $tov6 =$kdate.'<font color="808080"><strike>Andreis the Culler</strike></font><br>';}
		if ($acid == '3336625728') {$tov = $tov + 1; $tov7 =$kdate.'<font color="808080"><strike>The Aerakyn Commanders</strike></font><br>';}
		if ($acid == '1036876667') {$tov = $tov + 1; $tov8 =$kdate.'<font color="808080"><strike>Grendish</strike></font><br>';}
		if ($acid == '3651770174') {$tov = $tov + 1; $tov9 =$kdate.'<font color="808080"><strike>Tavekalem</strike></font><br>';}
		if ($acid == '4209888803') {$tov = $tov + 1; $tov10 =$kdate.'<font color="808080"><strike>Derig the Prime Executioner</strike></font><br>';}
		if ($acid == '1504763097') {$tov = $tov + 1; $tov11 =$kdate.'<font color="808080"><strike>Kigara the Blazewing and Kelana the Frostwing</strike></font><br>';}
		if ($acid == '416894482')  {$tov = $tov + 1; $tov12 =$kdate.'<font color="808080"><strike>Rarthek the Swiftwing</strike></font><br>';}
		if ($acid == '2914702347') {$tov = $tov + 1; $tov13 =$kdate.'<font color="808080"><strike>Caden and Keplin</strike></font><br>';}
		if ($acid == '3676973313') {$tov = $tov + 1; $tov14 =$kdate.'<font color="808080"><strike>Essedara and Jalkhir</strike></font><br>';}
		if ($acid == '2942303806') {$tov = $tov + 1; $tov15 =$kdate.'<font color="808080"><strike>Sontalak</strike></font><br>';}
		//Accursed Sanctum
		if ($acid == '3296875551') {$as = $as + 1; $as1 =$kdate.'<font color="808080"><strike>The Crumbling Emperor</strike></font><br>';}
		if ($acid == '958847238')  {$as = $as + 1; $as2 =$kdate.'<font color="808080"><strike>Matri Marn</strike></font><br>';}
		if ($acid == '1942052341') {$as = $as + 1; $as3 =$kdate.'<font color="808080"><strike>Sacrificer Buran</strike></font><br>';}
		if ($acid == '1471432653') {$as = $as + 1; $as4 =$kdate.'<font color="808080"><strike>The Legionnaires</strike></font><br>';}
		if ($acid == '1940806545') {$as = $as + 1; $as5 =$kdate.'<font color="808080"><strike>Sesria and Denani</strike></font><br>';}
		if ($acid == '3307822925') {$as = $as + 1; $as6 =$kdate.'<font color="808080"><strike>The Protector of Stone</strike></font><br>';}
		if ($acid == '287604278')  {$as = $as + 1; $as7 =$kdate.'<font color="808080"><strike>Kaasssrelik the Afflicted</strike></font><br>';}
		if ($acid == '2420391976') {$as = $as + 1; $as8 =$kdate.'<font color="808080"><strike>Subsistent Custodian</strike></font><br>';}
		if ($acid == '4226279029') {$as = $as + 1; $as9 =$kdate.'<font color="808080"><strike>Adherant Custodian</strike></font><br>';}
		if ($acid == '789224443')  {$as = $as + 1; $as10 =$kdate.'<font color="808080"><strike>Ageless Custodian</strike></font><br>';}
		if ($acid == '2508646099') {$as = $as + 1; $as11 =$kdate.'<font color="808080"><strike>Accursed Custodian</strike></font><br>';}
		//ToV Contested
		if ($acid == '2828051041') {$tovc = $tovc + 1; $tovc1 =$kdate.'<font color="808080"><strike>Draazak the Ancient</strike></font><br>';}
		if ($acid == '3607119179') {$tovc = $tovc + 1; $tovc2 =$kdate.'<font color="808080"><strike>Exarch Lorokai the Unliving</strike></font><br>';}
		//Fabled Kingdom of Sky
		if ($acid == '1344069514') {$king = $king + 1; $king1 =$kdate.'<font color="808080"><strike>Lord Vyemm</strike></font><br>';}
		if ($acid == '3194637595') {$king = $king + 1; $king2 =$kdate.'<font color="808080"><strike>Mutagenic Outcast</strike></font><br>';}
		if ($acid == '554855277')  {$king = $king + 1; $king3 =$kdate.'<font color="808080"><strike>Three Princes</strike></font><br>';}
		//Dreadscale's Maw
		if ($acid == '2371639852') {$dreadscale = $dreadscale + 1; $dreadscale1 =$kdate.'<font color="808080"><strike>Bristlebane</strike></font><br>';}
		if ($acid == '1302823374') {$dreadscale = $dreadscale + 1; $dreadscale2 =$kdate.'<font color="808080"><strike>Vulak\'Aerr the Dreadscale</strike></font><br>';}
		if ($acid == '1900278550') {$dreadscale = $dreadscale + 1; $dreadscale3 =$kdate.'<font color="808080"><strike>Telkorenar</strike></font><br>';}
		if ($acid == '2623491796') {$dreadscale = $dreadscale + 1; $dreadscale4 =$kdate.'<font color="808080"><strike>Irdul of the Glacier</strike></font><br>';}
		if ($acid == '2773056033') {$dreadscale = $dreadscale + 1; $dreadscale5 =$kdate.'<font color="808080"><strike>Lord Kriezenn</strike></font><br>';}
		if ($acid == '3396916306') {$dreadscale = $dreadscale + 1; $dreadscale6 =$kdate.'<font color="808080"><strike>Lord Feshlak</strike></font><br>';}
		if ($acid == '930839830')  {$dreadscale = $dreadscale + 1; $dreadscale7 =$kdate.'<font color="808080"><strike>Lady Mirenella</strike></font><br>';}		
		if ($acid == '3984592521') {$dreadscale = $dreadscale + 1; $dreadscale8 =$kdate.'<font color="808080"><strike>Cer\'matal the Gatekeeper</strike></font><br>';}
		//Fabled Deathtoll
		if ($acid == '2816466417') {$deathtoll = $deathtoll + 1; $deathtoll1 =$kdate.'<font color="808080"><strike>Tarinax the Destroyer</strike></font><br>';}
		if ($acid == '820520633')  {$deathtoll = $deathtoll + 1; $deathtoll2 =$kdate.'<font color="808080"><strike>Cruor Alluvium</strike></font><br>';}
		if ($acid == '4288882803') {$deathtoll = $deathtoll + 1; $deathtoll3 =$kdate.'<font color="808080"><strike>Amorphous Drake</strike></font><br>';}
		if ($acid == '70398889')   {$deathtoll = $deathtoll + 1; $deathtoll4 =$kdate.'<font color="808080"><strike>Fitzpitzle</strike></font><br>';}
		if ($acid == '616627029')  {$deathtoll = $deathtoll + 1; $deathtoll5 =$kdate.'<font color="808080"><strike>Yitzik the Hurler</strike></font><br>';}		
		//Age's End
		if ($acid == '1516187306') {$agesend = $agesend + 1; $agesend1 =$kdate.'<font color="808080"><strike>General Velryyn (Challenge)</strike></font><br>';}
		if ($acid == '1400749304') {$agesend = $agesend + 1; $agesend2 =$kdate.'<font color="808080"><strike>Roehn Theer (Challenge)</strike></font><br>';}
		if ($acid == '3596882581') {$agesend = $agesend + 1; $agesend3 =$kdate.'<font color="808080"><strike>General Velryyn</strike></font><br>';}
		if ($acid == '1089000969') {$agesend = $agesend + 1; $agesend4 =$kdate.'<font color="808080"><strike>Roehn Theer</strike></font><br>';}
		//AoM - Zavith'Loa: The Molten Pools
		if ($acid == '2955610207') {$malice1 = $malice1 + 1; $malice11 =$kdate.'<font color="808080"><strike>Perador the Mighty</strike></font><br>';}
		if ($acid == '3742464779') {$malice1 = $malice1 + 1; $malice12 =$kdate.'<font color="808080"><strike>The Crumbling Icon</strike></font><br>';}
		if ($acid == '2820033437') {$malice1 = $malice1 + 1; $malice13 =$kdate.'<font color="808080"><strike>Kerridicus Searskin</strike></font><br>';}
		if ($acid == '824121895')  {$malice1 = $malice1 + 1; $malice14 =$kdate.'<font color="808080"><strike>Teraradus the Gorer</strike></font><br>';}
		//AoM - Castle Highhold: No Quarter
		if ($acid == '1849147944') {$malice2 = $malice2 + 1; $malice21 =$kdate.'<font color="808080"><strike>Grethah the Frenzied</strike></font><br>';}
		if ($acid == '422638270')  {$malice2 = $malice2 + 1; $malice22 =$kdate.'<font color="808080"><strike>Zebrun the Torso</strike></font><br>';}
		if ($acid == '2151260932') {$malice2 = $malice2 + 1; $malice23 =$kdate.'<font color="808080"><strike>Grevog the Punisher</strike></font><br>';}
		//AoM - Brokenskull Bay: Fury of the Cursed
		if ($acid == '1748957509') {$malice3 = $malice3 + 1; $malice31 =$kdate.'<font color="808080"><strike>Captain Krasnok</strike></font><br>';}
		if ($acid == '523880915')  {$malice3 = $malice3 + 1; $malice32 =$kdate.'<font color="808080"><strike>Jessip Daggerheart</strike></font><br>';}
		if ($acid == '2251331689') {$malice3 = $malice3 + 1; $malice33 =$kdate.'<font color="808080"><strike>Swindler and the Brute</strike></font><br>';}
		//AoM - Temple of Ssraeshza: Echoes of Time
		if ($acid == '3928176072') {$malice4 = $malice4 + 1; $malice41 =$kdate.'<font color="808080"><strike>Arch Lich Rhag\'Zadune</strike></font><br>';}
		if ($acid == '2636383582') {$malice4 = $malice4 + 1; $malice42 =$kdate.'<font color="808080"><strike>Ka\'Rah Ferun</strike></font><br>';}
		if ($acid == '1950851179') {$malice4 = $malice4 + 1; $malice43 =$kdate.'<font color="808080"><strike>Diabo, Va, and Centi Kela\'Set</strike></font><br>';}
		if ($acid == '54563069')   {$malice4 = $malice4 + 1; $malice44 =$kdate.'<font color="808080"><strike>Farozth Ssravizh</strike></font><br>';}
		if ($acid == '3981373905') {$malice4 = $malice4 + 1; $malice45 =$kdate.'<font color="808080"><strike>Gomrim, Zwebek, Tonnin, and Yermon</strike></font><br>';}
		//AoM - Ossuary: Cathedral of Bones
		if ($acid == '1434280382' or $acid == '2017956309') {$malice5 = $malice5 + 1; $malice51 =$kdate.'<font color="808080"><strike>Primordial Ritualist Villandre V\'Zher</strike></font><br>';}
		if ($acid == '255893827')  {$malice5 = $malice5 + 1; $malice52 =$kdate.'<font color="808080"><strike>Protector of Bones</strike></font><br>';}
		if ($acid == '2435069152') {$malice5 = $malice5 + 1; $malice53 =$kdate.'<font color="808080"><strike>Virtuoso Edgar V\'Zann</strike></font><br>';}
		if ($acid == '3861054582') {$malice5 = $malice5 + 1; $malice54 =$kdate.'<font color="808080"><strike>Sacrificer Aevila D\'Serin</strike></font><br>';}		
		if ($acid == '2133480908') {$malice5 = $malice5 + 1; $malice55 =$kdate.'<font color="808080"><strike>Inquisitor Soronigus</strike></font><br>';}
		//AoM - Ossuary: The Altar of Malice
		if ($acid == '116845928')  {$malice6 = $malice6 + 1; $malice61 =$kdate.'<font color="808080"><strike>Construct of Malice</strike></font><br>';}
		if ($acid == '2521428217') {$malice6 = $malice6 + 1; $malice62 =$kdate.'<font color="808080"><strike>Tserrina Syl\'tor</strike></font><br>';}
		if ($acid == '3780034671') {$malice6 = $malice6 + 1; $malice63 =$kdate.'<font color="808080"><strike>Ritual Keeper V\'derin</strike></font><br>';}
		//Altar of Malice Avatars - The Precipice of Power
		if ($acid == '3785130348') {$aoma = $aoma + 1; $aoma1 =$kdate.'<font color="808080"><strike>Brell Serilis</strike></font><br>';}
		if ($acid == '3312622728') {$aoma = $aoma + 1; $aoma2 =$kdate.'<font color="808080"><strike>Cazic-Thule</strike></font><br>';}
		if ($acid == '1264497483') {$aoma = $aoma + 1; $aoma3 =$kdate.'<font color="808080"><strike>Fennin Ro</strike></font><br>';}
		if ($acid == '2302657105') {$aoma = $aoma + 1; $aoma4 =$kdate.'<font color="808080"><strike>Karana</strike></font><br>';}
		if ($acid == '3211824092') {$aoma = $aoma + 1; $aoma5 =$kdate.'<font color="808080"><strike>The Tribunal</strike></font><br>';}
		//Far Seas Distillery
		if ($acid == '3296712239') {$fsd = $fsd + 1; $fsd1=$kdate.'<font color="808080"><strike>Baz the Illusionist</strike></font><br>';}
		if ($acid == '3011045049') {$fsd = $fsd + 1; $fsd2 =$kdate.'<font color="808080"><strike>Danacio the Witchdoctor</strike></font><br>';}
		if ($acid == '1421921214') {$fsd = $fsd + 1; $fsd3 =$kdate.'<font color="808080"><strike>Brunhildre the Wench</strike></font><br>';}
		if ($acid == '600308520') {$fsd = $fsd + 1; $fsd4 =$kdate.'<font color="808080"><strike>Pirate Shaman Snaggletooth</strike></font><br>';}
		if ($acid == '1475875915') {$fsd = $fsd + 1; $fsd5 =$kdate.'<font color="808080"><strike>Kildiun the Drunkard</strike></font><br>';}
		if ($acid == '3452541444') {$fsd = $fsd + 1; $fsd6 =$kdate.'<font color="808080"><strike>Charanda</strike></font><br>';}
		if ($acid == '3134106258') {$fsd = $fsd + 1; $fsd7 =$kdate.'<font color="808080"><strike>Bull McCleran</strike></font><br>';}
		if ($acid == '1403850663') {$fsd = $fsd + 1; $fsd8 =$kdate.'<font color="808080"><strike>Swabber Rotgut</strike></font><br>';}
		if ($acid == '3399769629') {$fsd = $fsd + 1; $fsd9 =$kdate.'<font color="808080"><strike>Captain Mergin</strike></font><br>';}
		if ($acid == '615137073')  {$fsd = $fsd + 1; $fsd10 =$kdate.'<font color="808080"><strike>Brutas the Imbiber</strike></font><br>';}
		//Freethinkers
		if ($acid == '99686993')   {$eof = $eof + 1; $eof1 =$kdate.'<font color="808080"><strike>Malkonis D\'Morte (Challenge)</strike></font><br>';}
		if ($acid == '2412565810') {$eof = $eof + 1; $eof2 =$kdate.'<font color="808080"><strike>Treyloth D\'Kulvith (Challenge)</strike></font><br>';}
		if ($acid == '4141058174') {$eof = $eof + 1; $eof3 =$kdate.'<font color="808080"><strike>Othysis Muravian (Challenge)</strike></font><br>';}
		if ($acid == '1951259245') {$eof = $eof + 1; $eof4 =$kdate.'<font color="808080"><strike>Zylphax the Shredder (Challenge)</strike></font><br>';}
		if ($acid == '19578004')   {$eof = $eof + 1; $eof5 =$kdate.'<font color="808080"><strike>Malkonis D\'Morte</strike></font><br>';}
		if ($acid == '1874453956') {$eof = $eof + 1; $eof6 =$kdate.'<font color="808080"><strike>Treyloth D\'Kulvith</strike></font><br>';}
		if ($acid == '2647006286') {$eof = $eof + 1; $eof7 =$kdate.'<font color="808080"><strike>Othysis Muravian</strike></font><br>';}
		if ($acid == '3545123490') {$eof = $eof + 1; $eof8 =$kdate.'<font color="808080"><strike>Zylphax the 
		Shredder</strike></font><br>';}
		//Terrors of Thalumbra - Contested
		if ($acid == '3418973156') {$totc = $totc + 1; $totc1 =$kdate.'<font color="808080"><strike>Vanlith the Mysterious One</strike></font><br>';}
		if ($acid == '0') {$totc = $totc + 1; $totc2 =$kdate.'<font color="808080"><strike>Venekor</strike></font><br>';}
		//Terrors of Thalumbra - Maldura: Bhoughbh's Folly
		if ($acid == '2221464290') {$tot1 = $tot1 + 1; $tot11 =$kdate.'<font color="808080"><strike>Bhoughbh Nova-Prime</strike></font><br>';}
		if ($acid == '4084198004') {$tot1 = $tot1 + 1; $tot12 =$kdate.'<font color="808080"><strike>MCP-Powered Pulsar</strike></font><br>';}
		if ($acid == '1674639333') {$tot1 = $tot1 + 1; $tot13 =$kdate.'<font color="808080"><strike>The Tinkered Abomination</strike></font><br>';}
		if ($acid == '349685619') {$tot1 = $tot1 + 1; $tot14 =$kdate.'<font color="808080"><strike>Hovercopter Hingebot</strike></font><br>';}
		if ($acid == '2380175049') {$tot1 = $tot1 + 1; $tot15 =$kdate.'<font color="808080"><strike>The Malfunctioning Slaver</strike></font><br>';}
		if ($acid == '4208567903') {$tot1 = $tot1 + 1; $tot16 =$kdate.'<font color="808080"><strike>Electroshock Grinder VIII</strike></font><br>';}
		if ($acid == '1690121212') {$tot1 = $tot1 + 1; $tot17 =$kdate.'<font color="808080"><strike>Sentinel XXI</strike></font><br>';}
		if ($acid == '330957674') {$tot1 = $tot1 + 1; $tot18 =$kdate.'<font color="808080"><strike>Short-Circuited Construct Bot</strike></font><br>';}
		if ($acid == '2327007952') {$tot1 = $tot1 + 1; $tot19 =$kdate.'<font color="808080"><strike>Bhoughbh Model XVII</strike></font><br>';}
		//Terrors of Thalumbra - Maldura: Forge of Ashes
		if ($acid == '2769211148') {$tot2 = $tot2 + 1; $tot21 =$kdate.'<font color="808080"><strike>Kyrus of the Old Ways</strike></font><br>';}
		if ($acid == '2172784979') {$tot2 = $tot2 + 1; $tot22 =$kdate.'<font color="808080"><strike>The Forge Golem</strike></font><br>';}
		if ($acid == '3523870618') {$tot2 = $tot2 + 1; $tot23 =$kdate.'<font color="808080"><strike>Captain Ashenfell</strike></font><br>';}
		if ($acid == '1258335776') {$tot2 = $tot2 + 1; $tot24 =$kdate.'<font color="808080"><strike>Captain Graybeard</strike></font><br>';}
		if ($acid == '2897773351') {$tot2 = $tot2 + 1; $tot25 =$kdate.'<font color="808080"><strike>Uigirf, Htardlem, and Omzzem</strike></font><br>';}
		if ($acid == '996825775')  {$tot2 = $tot2 + 1; $tot26 =$kdate.'<font color="808080"><strike>Bereth Mathias</strike></font><br>';}
		if ($acid == '1282239033') {$tot2 = $tot2 + 1; $tot27 =$kdate.'<font color="808080"><strike>Kiernun the Lyrical</strike></font><br>';}
		if ($acid == '3580115843') {$tot2 = $tot2 + 1; $tot28 =$kdate.'<font color="808080"><strike>Cronnin & Dellmun</strike></font><br>';}
		//Terrors of Thalumbra - Stygian Threshold: Edge of Underfoot
		if ($acid == '3365912365') {$tot3 = $tot3 + 1; $tot31 =$kdate.'<font color="808080"><strike>Iron Forged Constructs</strike></font><br>';}
		if ($acid == '3214446523') {$tot3 = $tot3 + 1; $tot32 =$kdate.'<font color="808080"><strike>Jorik the Scourge</strike></font><br>';}
		if ($acid == '570169880')  {$tot3 = $tot3 + 1; $tot33 =$kdate.'<font color="808080"><strike>Crohp the Mighty</strike></font><br>';}
		if ($acid == '1459301006') {$tot3 = $tot3 + 1; $tot34 =$kdate.'<font color="808080"><strike>King Lockt</strike></font><br>';}
		if ($acid == '3488774964') {$tot3 = $tot3 + 1; $tot35 =$kdate.'<font color="808080"><strike>Wedge Tinderton</strike></font><br>';}
		//Terrors of Thalumbra - Kralet Penumbra: The Hive Mind
		if ($acid == '2222955101') {$tot4 = $tot4 + 1; $tot41 =$kdate.'<font color="808080"><strike>Kraletus</strike></font><br>';}
		if ($acid == '348161996')  {$tot4 = $tot4 + 1; $tot42 =$kdate.'<font color="808080"><strike>Ynonngozzz\'Koolbh</strike></font><br>';}
		if ($acid == '1674032986') {$tot4 = $tot4 + 1; $tot43 =$kdate.'<font color="808080"><strike>The Polliwog</strike></font><br>';}
		if ($acid == '4207863520') {$tot4 = $tot4 + 1; $tot44 =$kdate.'<font color="808080"><strike>Sath\'Oprusk</strike></font><br>';}
		if ($acid == '2378815094') {$tot4 = $tot4 + 1; $tot45 =$kdate.'<font color="808080"><strike>The Psionists</strike></font><br>';}
		if ($acid == '330122197')  {$tot4 = $tot4 + 1; $tot46 =$kdate.'<font color="808080"><strike>Ojuti the Vile</strike></font><br>';}
		if ($acid == '1688892227') {$tot4 = $tot4 + 1; $tot47 =$kdate.'<font color="808080"><strike>Karith\'Ta</strike></font><br>';}
		if ($acid == '4255326969') {$tot4 = $tot4 + 1; $tot48 =$kdate.'<font color="808080"><strike>Charrid the Mindwarper</strike></font><br>';}
		//The Siege
		if ($acid == '3653116707')  {$siege = $siege + 1; $siege1 =$kdate.'<font color="808080"><strike>The Weapon of War</strike></font><br>';}
		if ($acid == '1045649697')  {$siege = $siege + 1; $siege2 =$kdate.'<font color="808080"><strike>Sanctifier Goortuk Challenge Mode</strike></font><br>';}
		if ($acid == '94121355')  {$siege = $siege + 1; $siege3 =$kdate.'<font color="808080"><strike>Sanctifier Goortuk</strike></font><br>';}
		if ($acid == '3993082443')  {$siege = $siege + 1; $siege4 =$kdate.'<font color="808080"><strike>Durtung the Arm of War</strike></font><br>';}
		if ($acid == '4032494295')  {$siege = $siege + 1; $siege5 =$kdate.'<font color="808080"><strike>Kreelit, Caller of Hounds</strike></font><br>';}
		if ($acid == '2425891476')  {$siege = $siege + 1; $siege6 =$kdate.'<font color="808080"><strike>Fergul the Protector</strike></font><br>';}
		if ($acid == '283336935')  {$fcazic = $fcazic + 1; $fcazic1 =$kdate.'<font color="808080"><strike>Fabled Venekor</strike></font><br>';}
		//Fabled Fallen Dynasty
		if ($acid == '2773962347')  {$ffd = $ffd + 1; $ffd1 =$kdate.'<font color="808080"><strike>Fabled Chel\'Drak</strike></font><br>';}
		if ($acid == '238639788')   {$ffd = $ffd + 1; $ffd2 =$kdate.'<font color="808080"><strike>Fabled Xux\'laio</strike></font><br>';}
		if ($acid == '1119419037')  {$ffd = $ffd + 1; $ffd3 =$kdate.'<font color="808080"><strike>Fabled Bonesnapper</strike></font><br>';}
		//Kunark Ascending - Arcanna'se Spire: Order and Chaos
		if ($acid == '1594406007')  {$ka1 = $ka1 + 1; $ka11 =$kdate.'<font color="808080"><strike>Shanaira the Prestigious</strike></font>'.$ka11f.'<br>';}
		if ($acid == '1844904577')  {$ka1 = $ka1 + 1; $ka12 =$kdate.'<font color="808080"><strike>Amalgams of Order and Chaos</strike></font>'.$ka12f.'<br>';}
		if ($acid == '1788528280')  {$ka1 = $ka1 + 1; $ka13 =$kdate.'<font color="808080"><strike>Shanaira the Powermonger</strike></font>'.$ka13f.'<br>';}
		if ($acid == '4086535970')  {$ka1 = $ka1 + 1; $ka14 =$kdate.'<font color="808080"><strike>Botanist Heridal</strike></font>'.$ka14f.'<br>';}
		if ($acid == '2224334772')  {$ka1 = $ka1 + 1; $ka15 =$kdate.'<font color="808080"><strike>Guardian of Arcanna\'se</strike></font>'.$ka15f.'<br>';}
		if ($acid == '451949079')   {$ka1 = $ka1 + 1; $ka16 =$kdate.'<font color="808080"><strike>Memory of the Stolen</strike></font>'.$ka16f.'<br>';}
		//Kunark Ascending - Ruins of Kaesora: Ancient Xalgozian Temple
		if ($acid == '3349279994')  {$ka2 = $ka2 + 1; $ka21 =$kdate.'<font color="808080"><strike>Xalgoz</strike></font><br>';}
		if ($acid == '4001373713')  {$ka2 = $ka2 + 1; $ka22 =$kdate.'<font color="808080"><strike>Sentinel Primatious</strike></font><br>';}
		if ($acid == '3083534453')  {$ka2 = $ka2 + 1; $ka23 =$kdate.'<font color="808080"><strike>Strathbone Runelord</strike></font><br>';}
		if ($acid == '784486863')   {$ka2 = $ka2 + 1; $ka24 =$kdate.'<font color="808080"><strike>Chomp</strike></font><br>';}
		if ($acid == '1506107737')  {$ka2 = $ka2 + 1; $ka25 =$kdate.'<font color="808080"><strike>Valigez, the Entomber</strike></font><br>';}
		//Kunark Ascending - Crypt of Dalnir: The Kly Stronghold
		if ($acid == '3579214093')  {$ka3 = $ka3 + 1; $ka31 =$kdate.'<font color="808080"><strike>The Kly</strike></font><br>';}
		if ($acid == '1094703574')  {$ka3 = $ka3 + 1; $ka32 =$kdate.'<font color="808080"><strike>Gorius the Gray</strike></font><br>';}
		if ($acid == '827665753')   {$ka3 = $ka3 + 1; $ka33 =$kdate.'<font color="808080"><strike>Brutius the Skulk</strike></font><br>';}
		if ($acid == '2824633571')  {$ka3 = $ka3 + 1; $ka34 =$kdate.'<font color="808080"><strike>Danariun, the Crypt Keeper</strike></font><br>';}
		if ($acid == '3747302517')  {$ka3 = $ka3 + 1; $ka35 =$kdate.'<font color="808080"><strike>Lumpy Goo</strike></font><br>';}
		//Kunark Ascending - Lost City of Torsis: Ashiirian Court
		if ($acid == '434391945')   {$ka4 = $ka4 + 1; $ka41 =$kdate.'<font color="808080"><strike>Lord Rak\'Ashiir</strike></font>'.$ka41f.'<br>';}
		if ($acid == '1860401951')  {$ka4 = $ka4 + 1; $ka42 =$kdate.'<font color="808080"><strike>Lord Ghiosk</strike></font>'.$ka42f.'<br>';}
		if ($acid == '512331664')  {$ka4 = $ka4 + 1; $ka43 =$kdate.'<font color="808080"><strike>The Black Reaver</strike></font>'.$ka43f.'<br>';}
		if ($acid == '2273369642')  {$ka4 = $ka4 + 1; $ka44 =$kdate.'<font color="808080"><strike>The Captain of the Guard</strike></font>'.$ka44f.'<br>';}
		if ($acid == '4035440316')  {$ka4 = $ka4 + 1; $ka45 =$kdate.'<font color="808080"><strike>Gyrating Green Slime</strike></font>'.$ka45f.'<br>';}
		//Kunark Ascending - Vaedenmoor, Realm of Despair
		if ($acid == '394122630')   {$ka5 = $ka5 + 1; $ka51 =$kdate.'<font color="808080"><strike>Setri Lureth</strike></font>'.$ka51f.'<br>';}
		if ($acid == '4263407795')  {$ka5 = $ka5 + 1; $ka52 =$kdate.'<font color="808080"><strike>Raenha, Sister of Remorse</strike></font>'.$ka52f.'<br>';}
		if ($acid == '1618666768')  {$ka5 = $ka5 + 1; $ka53 =$kdate.'<font color="808080"><strike>Vhaksiz the Shade</strike></font>'.$ka53f.'<br>';}
		if ($acid == '269488543')   {$ka5 = $ka5 + 1; $ka54 =$kdate.'<font color="808080"><strike>Anaheed the Dreamkeeper</strike></font>'.$ka54f.'<br>';}
		if ($acid == '2300133413')  {$ka5 = $ka5 + 1; $ka55 =$kdate.'<font color="808080"><strike>Hobgoblin Anguish Lord</strike></font>'.$ka55f.'<br>';}
		//Kunark Ascending - Vaedenmoor, Heart of Nightmares
		if ($acid == '3190088161')  {$ka6 = $ka6 + 1; $ka61 =$kdate.'<font color="808080"><strike>Territus, the Deathbringer</strike></font>'.$ka61f.'<br>';}
		if ($acid == '3374567799')  {$ka6 = $ka6 + 1; $ka62 =$kdate.'<font color="808080"><strike>Baliath, Harbinger of Nightmares</strike></font>'.$ka62f.'<br>';}
		if ($acid == '1464288468')  {$ka6 = $ka6 + 1; $ka63 =$kdate.'<font color="808080"><strike>The Summoned Foes</strike></font>'.$ka63f.'<br>';}
		if ($acid == '657305691')  {$ka6 = $ka6 + 1; $ka64 =$kdate.'<font color="808080"><strike>Warden of Nightmares</strike></font>'.$ka64f.'<br>';}
		//Kunark Ascending - Chamber of Rejuvenation
		if ($acid == '4063929859')  {$ka7 = $ka7 + 1; $ka71 =$kdate.'<font color="808080"><strike>The Rejuvenating One</strike></font>'.$ka71f.'<br>';}
		}
		//Flawless KA
		for ($b=0; $b<=$ktot; $b++) {
		$acid = $achieve[$b]['id'];
		$fkdate = "";
		if (($this->config('eq2progress_date')) == TRUE ) 		
		{ ($fstamp = date('m/d/Y', $achieve[$b]['completedtimestamp'])); 
        ($fkdate = '<font color="white">'.$fstamp.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>');	}
		if ($acid == '1079927266')  {$ka11 =$fkdate.'<font color="808080"><strike>Shanaira the Prestigious</strike></font> FLAWLESS<br>';}
		if ($acid == '4134444588')  {$ka12 =$fkdate.'<font color="808080"><strike>Amalgams of Order and Chaos</strike></font> FLAWLESS<br>';}
		if ($acid == '4043528757')  {$ka13 =$fkdate.'<font color="808080"><strike>Shanaira the Powermonger</strike></font> FLAWLESS<br>';}
		if ($acid == '1745488783')  {$ka14 =$fkdate.'<font color="808080"><strike>Botanist Heridal</strike></font> FLAWLESS<br>';}
		if ($acid == '520960793')   {$ka15 =$fkdate.'<font color="808080"><strike>Guardian of Arcanna\'se</strike></font> FLAWLESS<br>';}
		if ($acid == '2171186874')  {$ka16 =$fkdate.'<font color="808080"><strike>Memory of the Stolen</strike></font> FLAWLESS<br>';}
		if ($acid == '1362160951')  {$ka21 =$fkdate.'<font color="808080"><strike>Xalgoz</strike></font> FLAWLESS<br>';}
		if ($acid == '1811878238')  {$ka22 =$fkdate.'<font color="808080"><strike>Sentinel Primatious</strike></font> FLAWLESS<br>';}
		if ($acid == '559552952')   {$ka23 =$fkdate.'<font color="808080"><strike>Strathbone Runelord</strike></font> FLAWLESS<br>';}
		if ($acid == '3092465666')  {$ka24 =$fkdate.'<font color="808080"><strike>Chomp</strike></font> FLAWLESS<br>';}
		if ($acid == '3478419604')  {$ka25 =$fkdate.'<font color="808080"><strike>Valigez, the Entomber</strike></font> FLAWLESS<br>';}
		if ($acid == '1137139904')  {$ka31 =$fkdate.'<font color="808080"><strike>The Kly</strike></font> FLAWLESS<br>';}
		if ($acid == '3650001564')  {$ka32 =$fkdate.'<font color="808080"><strike>Gorius the Gray</strike></font> FLAWLESS<br>';}
		if ($acid == '2850319891')  {$ka33 =$fkdate.'<font color="808080"><strike>Brutius the Skulk</strike></font> FLAWLESS<br>';}
		if ($acid == '820854697')   {$ka34 =$fkdate.'<font color="808080"><strike>Danariun, the Crypt Keeper</strike></font> FLAWLESS<br>';}
		if ($acid == '1206521663')  {$ka35 =$fkdate.'<font color="808080"><strike>Lumpy Goo</strike></font> FLAWLESS<br>';}
		if ($acid == '866554065')   {$ka41 =$fkdate.'<font color="808080"><strike>Lord Rak\'Ashiir</strike></font> FLAWLESS<br>';}
		if ($acid == '1151443015')  {$ka42 =$fkdate.'<font color="808080"><strike>Lord Ghiosk</strike></font> FLAWLESS<br>';}
		if ($acid == '885740744')   {$ka43 =$fkdate.'<font color="808080"><strike>The Black Reaver</strike></font> FLAWLESS<br>';}
		if ($acid == '2915173746')  {$ka44 =$fkdate.'<font color="808080"><strike>The Captain of the Guard</strike></font> FLAWLESS<br>';}
		if ($acid == '3670357476')  {$ka45 =$fkdate.'<font color="808080"><strike>Gyrating Green Slime</strike></font> FLAWLESS<br>';}
		if ($acid == '1027542750')    {$ka51 =$fkdate.'<font color="808080"><strike>Setri Lureth</strike></font> FLAWLESS<br>';}
		if ($acid == '3562843115')  {$ka52 =$fkdate.'<font color="808080"><strike>Raenha, Sister of Remorse</strike></font> FLAWLESS<br>';}
		if ($acid == '1245199944')  {$ka53 =$fkdate.'<font color="808080"><strike>Vhaksiz the Shade</strike></font> FLAWLESS<br>';}
		if ($acid == '978504391')   {$ka54 =$fkdate.'<font color="808080"><strike>Anaheed the Dreamkeeper</strike></font> FLAWLESS<br>';}
		if ($acid == '2740689789')  {$ka55 =$fkdate.'<font color="808080"><strike>Hobgoblin Anguish Lord</strike></font> FLAWLESS<br>';}
		if ($acid == '3686693628')  {$ka61 =$fkdate.'<font color="808080"><strike>Territus, the Deathbringer</strike></font> FLAWLESS<br>';}
		if ($acid == '2897824362')  {$ka62 =$fkdate.'<font color="808080"><strike>Baliath, Harbinger of Nightmares</strike></font> FLAWLESS<br>';}
		if ($acid == '853401545')  {$ka63 =$fkdate.'<font color="808080"><strike>The Summoned Foes</strike></font> FLAWLESS<br>';}
		if ($acid == '1119300422')  {$ka64 =$fkdate.'<font color="808080"><strike>Warden of Nightmares</strike></font> FLAWLESS<br>';}
		if ($acid == '393840919')  {$ka71 =$fkdate.'<font color="808080"><strike>The Rejuvenating One</strike></font> FLAWLESS<br>';}
		}
		$killslist = array($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$contested,
						   $ar1,$ar2,$ar3,$ar4,$ar5,$ar6,$ar7,$ar8,$ar9,$ar10,$arena,
						   $h1,$h2,$h3,$h4,$h5,$h6,$h7,$h8,$h9,$h10,$h11,$h12,$harrows,
						   $sl1,$sl2,$sl3,$sl4,$sl5,$sl6,$sl7,$sl8,$sl9,$sl10,$sl11,$sl12,$sleeper,
						   $a1,$a2,$a3,$a4,$a5,$a6,$altar,
						   $p1,$p2,$p3,$p4,$p5,$p6,$p7,$pow,
						   $d1,$d2,$d3,$dread,
						   $sr1,$sr2,$sr3,$sr4,$sr5,$sr6,$sr7,$sr8,$sr9,$sirens,
						   $dj1,$dj2,$djinn,
						   $tov1,$tov2,$tov3,$tov4,$tov5,$tov6,$tov7,$tov8,$tov9,$tov10,$tov11,$tov12,$tov13,$tov14,$tov15,$tov,
						   $as1,$as2,$as3,$as4,$as5,$as6,$as7,$as8,$as9,$as10,$as11,$as,
						   $tovc1,$tovc2,$tovc,
						   $king1,$king2,$king3,$king,
						   $dreadscale1,$dreadscale2,$dreadscale3,$dreadscale4,$dreadscale5,$dreadscale6,$dreadscale7,$dreadscale8,$dreadscale,
						   $deathtoll1,$deathtoll2,$deathtoll3,$deathtoll4,$deathtoll5,$deathtoll,
						   $agesend1,$agesend2,$agesend3,$agesend4,$agesend,
						   $aoma1,$aoma2,$aoma3,$aoma4,$aoma5,$aoma,
						   $malice11,$malice12,$malice13,$malice14,$malice1,
						   $malice21,$malice22,$malice23,$malice2,
						   $malice31,$malice32,$malice33,$malice3,
						   $malice41,$malice42,$malice43,$malice44,$malice45,$malice4,
						   $malice51,$malice52,$malice53,$malice54,$malice55,$malice5,
						   $malice61,$malice62,$malice63,$malice6,
						   $fsd1,$fsd2,$fsd3,$fsd4,$fsd5,$fsd6,$fsd7,$fsd8,$fsd9,$fsd10,$fsd,
						   $eof1,$eof2,$eof3,$eof4,$eof5,$eof6,$eof7,$eof8,$eof,
						   $totc1,$totc,
						   $tot11,$tot12,$tot13,$tot14,$tot15,$tot16,$tot17,$tot18,$tot19,$tot1,
						   $tot21,$tot22,$tot23,$tot24,$tot25,$tot26,$tot27,$tot28,$tot2,
						   $tot31,$tot32,$tot33,$tot34,$tot35,$tot3,
						   $tot41,$tot42,$tot43,$tot44,$tot45,$tot46,$tot47,$tot48,$tot4,
						   $siege1,$siege2,$siege3,$siege4,$siege5,$siege6,$siege,
						   $fcazic1,$fcazic,
						   $ffd1,$ffd2,$ffd3,$ffd,
						   $ka11,$ka12,$ka13,$ka14,$ka15,$ka16,$ka1,
						   $ka21,$ka22,$ka23,$ka24,$ka25,$ka2,
						   $ka31,$ka32,$ka33,$ka34,$ka35,$ka3,
						   $ka41,$ka42,$ka43,$ka44,$ka45,$ka4,
						   $ka51,$ka52,$ka53,$ka54,$ka55,$ka5,
						   $ka61,$ka62,$ka63,$ka64,$ka6,
						   $ka71,$ka7
						   );
		$this->pdc->put('portal.module.eq2progress.'.$this->root_path, $killslist, 3600);
				}
		$contes = ($killslist[0].$killslist[1].$killslist[2].$killslist[3].$killslist[4]
		           .$killslist[5].$killslist[6].$killslist[7].$killslist[8]);
		$zonetotal1 = ($killslist[9]);
		$gods = ($killslist[10].$killslist[11].$killslist[12].$killslist[13].$killslist[14]
		         .$killslist[15].$killslist[16].$killslist[17].$killslist[18].$killslist[19]);
		$zonetotal2 = ($killslist[20]);
		$har = ($killslist[21].$killslist[22].$killslist[23].$killslist[24].$killslist[25].$killslist[26]
				.$killslist[27].$killslist[28].$killslist[29].$killslist[30].$killslist[31].$killslist[32]);
		$zonetotal3 = ($killslist[33]);
		$slep = ($killslist[34].$killslist[35].$killslist[36].$killslist[37].$killslist[38].$killslist[39]
				.$killslist[40].$killslist[41].$killslist[42].$killslist[43].$killslist[44].$killslist[45]);
		$zonetotal4 = ($killslist[46]);
		$ala = ($killslist[47].$killslist[48].$killslist[49].$killslist[50].$killslist[51].$killslist[52]);
		$zonetotal5 = ($killslist[53]);
		$pla = ($killslist[54].$killslist[55].$killslist[56].$killslist[57].$killslist[58].$killslist[59].$killslist[60]);
		$zonetotal6 = ($killslist[61]);
		$dred = ($killslist[62].$killslist[63].$killslist[64]);
		$zonetotal7 = ($killslist[65]);
		$sir = ($killslist[66].$killslist[67].$killslist[68].$killslist[69].$killslist[70]
		        .$killslist[71].$killslist[72].$killslist[73].$killslist[74]);
		$zonetotal8 = ($killslist[75]);
		$djin = ($killslist[76].$killslist[77]);
		$zonetotal9 = ($killslist[78]);
		$tears = ($killslist[79].$killslist[80].$killslist[81].$killslist[82].$killslist[83].$killslist[84].$killslist[85].$killslist[86]
		          .$killslist[87].$killslist[88].$killslist[89].$killslist[90].$killslist[91].$killslist[92].$killslist[93]);
	    $zonetotal10 = ($killslist[94]);
		$ascent = ($killslist[95].$killslist[96].$killslist[97].$killslist[98].$killslist[99].$killslist[100]
		           .$killslist[101].$killslist[102].$killslist[103].$killslist[104].$killslist[105]);
		$zonetotal11 = ($killslist[106]);
		$tovcont = ($killslist[107].$killslist[108]);
		$zonetotal12 = ($killslist[109]);
		$kingdom = ($killslist[110].$killslist[111].$killslist[112]);
		$zonetotal13 = ($killslist[113]);
		$dreadmaw = ($killslist[114].$killslist[115].$killslist[116].$killslist[117].$killslist[118].$killslist[119].$killslist[120].$killslist[121]);
		$zonetotal14 = ($killslist[122]);		
		$fdeathtoll = ($killslist[123].$killslist[124].$killslist[125].$killslist[126].$killslist[127]);
		$zonetotal15 = ($killslist[128]);
		$agesen = ($killslist[129].$killslist[130].$killslist[131].$killslist[132]);
		$zonetotal16 = ($killslist[133]);
        $aomavatar = ($killslist[134].$killslist[135].$killslist[136].$killslist[137].$killslist[138]);
		$zonetotal17 = ($killslist[139]);
		$mal1 = ($killslist[140].$killslist[141].$killslist[142].$killslist[143]);
		 $zonetotal18 = ($killslist[144]);
		$mal2 = ($killslist[145].$killslist[146].$killslist[147]);
		$zonetotal19 = ($killslist[148]);
		$mal3 = ($killslist[149].$killslist[150].$killslist[151]);
		$zonetotal20 = ($killslist[152]);
		$mal4 = ($killslist[153].$killslist[154].$killslist[155].$killslist[156].$killslist[157]);
		$zonetotal21 = ($killslist[158]);
		$mal5 = ($killslist[159].$killslist[160].$killslist[161].$killslist[162].$killslist[163]);
		$zonetotal22 = ($killslist[164]);
		$mal6 = ($killslist[165].$killslist[166].$killslist[167]);
		$zonetotal23 = ($killslist[168]);
		$fsdbb = ($killslist[169].$killslist[170].$killslist[171].$killslist[172].$killslist[173].$killslist[174].$killslist[175].$killslist[176].$killslist[177].$killslist[178]);
		$zonetotal24 = ($killslist[179]);
		$eoff = ($killslist[180].$killslist[181].$killslist[182].$killslist[183].$killslist[184].$killslist[185].$killslist[186].$killslist[187]);
		$zonetotal25 = ($killslist[188]);
		$terrc = ($killslist[189]);
		$zonetotal26 = ($killslist[190]);
		$terr1 = ($killslist[191].$killslist[192].$killslist[193].$killslist[194].$killslist[195].$killslist[196].$killslist[197].$killslist[198].$killslist[199]);
		$zonetotal27 = ($killslist[200]);
		$terr2 = ($killslist[201].$killslist[202].$killslist[203].$killslist[204].$killslist[205].$killslist[206].$killslist[207].$killslist[208]);
		$zonetotal28 = ($killslist[209]);
		$terr3 = ($killslist[210].$killslist[211].$killslist[212].$killslist[213].$killslist[214]);
		$zonetotal29 = ($killslist[215]);
		$terr4 = ($killslist[216].$killslist[217].$killslist[218].$killslist[219].$killslist[220].$killslist[221].$killslist[222].$killslist[223]);
		$zonetotal30 = ($killslist[224]);
		$tsiege = ($killslist[225].$killslist[226].$killslist[227].$killslist[228].$killslist[229].$killslist[230]);
		$zonetotal31 = ($killslist[231]);
		$tfcazic = ($killslist[232]);
		$zonetotal32 = ($killslist[233]);
		$tffd = ($killslist[234].$killslist[235].$killslist[236]);
		$zonetotal33 = ($killslist[237]);
		$kuna1 = ($killslist[238].$killslist[239].$killslist[240].$killslist[241].$killslist[242].$killslist[243]);
		$zonetotal34 = ($killslist[244]);
		$kuna2 = ($killslist[245].$killslist[246].$killslist[247].$killslist[248].$killslist[249]);
		$zonetotal35 = ($killslist[250]);
		$kuna3 = ($killslist[251].$killslist[252].$killslist[253].$killslist[254].$killslist[255]);
		$zonetotal36 = ($killslist[256]);
		$kuna4 = ($killslist[257].$killslist[258].$killslist[259].$killslist[260].$killslist[261]);
		$zonetotal37 = ($killslist[262]);
		$kuna5 = ($killslist[263].$killslist[264].$killslist[265].$killslist[266].$killslist[267]);
		$zonetotal38 = ($killslist[268]);
		$kuna6 = ($killslist[269].$killslist[270].$killslist[271].$killslist[272]);
		$zonetotal39 = ($killslist[273]);
		$kuna7 = ($killslist[274]);
		$zonetotal40 = ($killslist[275]);
		$zonename1 = $cval; 	      $zonemax1 = $contmax;        $zonetip1 = $contes;
		$zonename2 = $arval; 	      $zonemax2 = $arenamax;       $zonetip2 = $gods;
		$zonename3 = $hval;  	      $zonemax3 = $harrowmax;      $zonetip3 = $har;
		$zonename4 = $slval; 	      $zonemax4 = $sleepermax;     $zonetip4 = $slep;
		$zonename5 = $aval;  	      $zonemax5 = $altarmax;       $zonetip5 = $ala;
		$zonename6 = $pval;  	      $zonemax6 = $powmax;         $zonetip6 = $pla;
		$zonename7 = $dval;  	      $zonemax7 = $dreadmax;       $zonetip7 = $dred;
		$zonename8 = $srval; 	      $zonemax8 = $sirenmax;       $zonetip8 = $sir;
		$zonename9 = $djval; 	      $zonemax9 = $djinnmax;       $zonetip9 = $djin;
		$zonename10 = $tovval;        $zonemax10 = $tovmax;        $zonetip10 = $tears;
		$zonename11 = $asval;         $zonemax11 = $asmax;   	   $zonetip11 = $ascent;
		$zonename12 = $tovcval;       $zonemax12 = $tovcmax;       $zonetip12 = $tovcont;
		$zonename13 = $kingval;       $zonemax13 = $kingmax; 	   $zonetip13 = $kingdom;
		$zonename14 = $dreadscaleval; $zonemax14 = $dreadscalemax; $zonetip14 = $dreadmaw;
		$zonename15 = $deathtollval;  $zonemax15 = $deathtollmax;  $zonetip15 = $fdeathtoll;
		$zonename16 = $agesendval;    $zonemax16 = $agesendmax;    $zonetip16 = $agesen;
		$zonename17 = $aomaval;       $zonemax17 = $aomamax;       $zonetip17 = $aomavatar;
		$zonename18 = $malice1val;    $zonemax18 = $malice1max;    $zonetip18 = $mal1;
		$zonename19 = $malice2val;    $zonemax19 = $malice2max;    $zonetip19 = $mal2;
		$zonename20 = $malice3val;    $zonemax20 = $malice3max;    $zonetip20 = $mal3;
		$zonename21 = $malice4val;    $zonemax21 = $malice4max;    $zonetip21 = $mal4;
		$zonename22 = $malice5val;    $zonemax22 = $malice5max;    $zonetip22 = $mal5;
		$zonename23 = $malice6val;    $zonemax23 = $malice6max;    $zonetip23 = $mal6;
		$zonename24 = $fsdval;        $zonemax24 = $fsdmax;        $zonetip24 = $fsdbb;
		$zonename25 = $eofval;        $zonemax25 = $eofmax;        $zonetip25 = $eoff;
		$zonename26 = $totcval;       $zonemax26 = $totcmax;       $zonetip26 = $terrc;
		$zonename27 = $tot1val;       $zonemax27 = $tot1max;       $zonetip27 = $terr1;
		$zonename28 = $tot2val;       $zonemax28 = $tot2max;       $zonetip28 = $terr2;
		$zonename29 = $tot3val;       $zonemax29 = $tot3max;       $zonetip29 = $terr3;
		$zonename30 = $tot4val;       $zonemax30 = $tot4max;       $zonetip30 = $terr4;
		$zonename31 = $siegeval;      $zonemax31 = $siegemax;      $zonetip31 = $tsiege;
		$zonename32 = $fcazicval;     $zonemax32 = $fcazicmax;     $zonetip32 = $tfcazic;
		$zonename33 = $ffdval;     	  $zonemax33 = $ffdmax;        $zonetip33 = $tffd;
		$zonename34 = $ka1val;     	  $zonemax34 = $ka1max;        $zonetip34 = $kuna1;
		$zonename35 = $ka2val;     	  $zonemax35 = $ka2max;        $zonetip35 = $kuna2;
		$zonename36 = $ka3val;     	  $zonemax36 = $ka3max;        $zonetip36 = $kuna3;
		$zonename37 = $ka4val;     	  $zonemax37 = $ka4max;        $zonetip37 = $kuna4;
		$zonename38 = $ka5val;     	  $zonemax38 = $ka5max;        $zonetip38 = $kuna5;
		$zonename39 = $ka6val;     	  $zonemax39 = $ka6max;        $zonetip39 = $kuna6;
		$zonename40 = $ka7val;     	  $zonemax40 = $ka7max;        $zonetip40 = $kuna7;
		$out = ''; 
			for($i=1;$i<=40;$i++) {
			$check = ${"zone".$i};
			if ($check == TRUE) {
			$text = ${"zonename".$i}; $value = ${"zonetotal".$i}; $max = ${"zonemax".$i}; $tooltip = ${"zonetip".$i};	
			$out .= $this->bar_out($i,$value,$max,$text,$tooltip);} 
			}
		return $out;
		return $this->bar_out();	
	}
		
	public function bar_out($num,$value,$max,$text,$tooltip) {
		if ($value == $max){$text = '<strike>'.$text.'</strike>';}
		if(empty($tooltip)) return $this->jquery->ProgressBar('eq2progress_'.unique_id(), 0, array(
			'total' 	=> $max,
			'completed' => $value,
			'text'		=> $text.' %progress%',
			'txtalign'	=> 'center',
		));
		$name = 'eq2progress_tt_'.unique_id();
		$positions = array(
			'left' => array('my' => 'left top', 'at' => 'right center', 'name' => $name),
			'middle' => array('name' => $name),
			'right' => array('my' => 'right center', 'at' => 'left center', 'name' => $name ),
			'bottom' => array('my' => 'bottom center', 'at' => 'top center', 'name' => $name ),
		);
		$arrPosition = (isset($positions[$this->position])) ? $positions[$this->position] : $positions['middle'];
		$tooltipopts	= array('label' => $this->jquery->ProgressBar('eq2progress_'.unique_id(), 0, array(
			'total' 	=> $max,
			'completed' => $value,
			'text'		=> $text.' %progress%',
			'txtalign'	=> 'center',
		)), 'content' => $tooltip);
		$tooltipopts	= array_merge($tooltipopts, $arrPosition);
		return new htooltip('eq2progress_tt'.$num, $tooltipopts);
	}
}
?>
