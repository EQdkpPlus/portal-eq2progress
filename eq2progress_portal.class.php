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
 * @copyright	2006-2011 EQdkp-Plus Developer Team
 * @link		http://eqdkp-plus.com
 * @package		eqdkp-plus
 * @version		$Rev: 00002 $
 * 
 * $Id: eq2progress_portal.class.php 00002 2013-11-18 18:20:34Z Darkmaeg $
 * Modified Version of Hoofy's mybars progression module
 * This version populates the guild raid achievements from the Data Api
 *
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
 * V1.5 Added Contested X4 in High Keep
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
		'version'		=> '3.3',
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
			'eq2progress_date'	=> array(
				'name'		=> 'eq2progress_date',
				'language'	=> 'eq2progress_date',
				'type'	=> 'radio',
			),
		);
		return $settings;
	}
		
	public function output() {
		if($this->config('eq2progress_headtext')){
			$this->header = sanitize($this->config('eq2progress_headtext'));
		}
		$maxbars = 0;
		if (($this->config('eq2progress_contested')) == True ) 		{ ($maxbars = $maxbars + 1); ($zone1 = TRUE); }
		if (($this->config('eq2progress_arena')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone2 = TRUE); }
		if (($this->config('eq2progress_harrows')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone3 = TRUE); }
		if (($this->config('eq2progress_sleepers')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone4 = TRUE); }
		if (($this->config('eq2progress_abhorrence')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone5 = TRUE); }
		if (($this->config('eq2progress_plane')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone6 = TRUE); }
		if (($this->config('eq2progress_dreadcutter')) == TRUE ) 	{ ($maxbars = $maxbars + 1); ($zone7 = TRUE); }
		if (($this->config('eq2progress_sirens')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone8 = TRUE); }
		if (($this->config('eq2progress_desert')) == TRUE ) 			{ ($maxbars = $maxbars + 1); ($zone9 = TRUE); }
		if (($this->config('eq2progress_veeshan')) == TRUE )			{ ($maxbars = $maxbars + 1); ($zone10 = TRUE); }
		if (($this->config('eq2progress_accursed')) == TRUE )		{ ($maxbars = $maxbars + 1); ($zone11 = TRUE); }
		if (($this->config('eq2progress_vesspyr')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone12 = TRUE); }
		if (($this->config('eq2progress_kingdom')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone13 = TRUE); }
		if (($this->config('eq2progress_dreadscale')) == TRUE ) 		{ ($maxbars = $maxbars + 1); ($zone14 = TRUE); }
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
		$arena = 0; $contested = 0; $harrows = 0; $sleeper = 0; $altar = 0; $pow = 0; $dread = 0; $sirens = 0; $djinn= 0;
		$tov = 0; $as = 0; $tovc = 0; $king = 0; $dreadscale = 0; $deathtoll = 0; $agesend = 0; 
		$malice1 = 0; $malice2 = 0; $malice3 = 0; $malice4 = 0; $malice5 = 0; $malice6 = 0; $aoma = 0; $fsd = 0;
		$arenamax = 10; $contmax = 9; $harrowmax = 12; $sleepermax = 12; $altarmax = 6; $powmax = 7; $dreadmax = 3; $sirenmax = 9; $djinnmax = 2;
		$tovmax = 15; $asmax = 11; $tovcmax = 2; $kingmax = 3; $dreadscalemax = 8; $deathtollmax = 5; $agesendmax = 4; 
		$malice1max = 4; $malice2max = 3; $malice3max = 3; $malice4max = 5; $malice5max = 5; $malice6max = 3; $aomamax = 4; $fsdmax = 10;
		$this->game->new_object('eq2_daybreak', 'daybreak', array());
		if(!is_object($this->game->obj['daybreak'])) return "";
		$progdata = $this->game->obj['daybreak']->guildinfo($this->config->get('guildtag'), $this->config->get('uc_servername'), false);
		$achieve  = $progdata['guild_list'][0]['achievement_list'];	
		$ktot = count($achieve);
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
		$h11='<font color="white">Melanie Everling</font><br>';	$h12=$spacer.'<font color="white">Caerina the Lost</font><br>';	
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
		$malice61=$spacer.'<font color="white">Ritual Keeper V\'derin</font><br>'; $malice62=$spacer.'<font color="white">Tserrina Syl\'tor</font><br>'; 
		$malice63=$spacer.'<font color="white">Construct of Malice</font><br>'; 		
		$aomaval=$this->user->lang('eq2progress_f_eq2progress_aomavatar');
		$aoma1=$spacer.'<font color="white">Cazic-Thule</font><br>'; $aoma2=$spacer.'<font color="white">Fennin Ro</font><br>'; 
		$aoma3=$spacer.'<font color="white">Karana</font><br>'; $aoma4=$spacer.'<font color="white">The Tribunal</font><br>';
		$fsdval=$this->user->lang('eq2progress_f_eq2progress_fsdistillery');
		$fsd1=$spacer.'<font color="white">Brutas the Imbiber</font><br>'; $fsd2=$spacer.'<font color="white">Captain Mergin</font><br>'; 	
		$fsd3=$spacer.'<font color="white">Swabber Rotgut</font><br>'; $fsd4=$spacer.'<font color="white">Bull McCleran</font><br>'; 	
		$fsd5=$spacer.'<font color="white">Charanda</font><br>'; $fsd6=$spacer.'<font color="white">Kildiun the Drunkard</font><br>'; 	
		$fsd7=$spacer.'<font color="white">Pirate Shaman Snaggletooth</font><br>'; $fsd8=$spacer.'<font color="white">Brunhildre the Wench</font><br>'; 	
		$fsd9=$spacer.'<font color="white">Danacio the Witchdoctor</font><br>'; $fsd10=$spacer.'<font color="white">Baz the Illusionist</font><br>'; 		
		//Check which have been killed
		$killslist = $this->pdc->get('portal.module.eq2progress.'.$this->root_path);
				if (!$killslist){
		for ($a=0; $a<=$ktot; $a++) {
		//$kdate = date('m/d/Y', $achieve[$a]['completedtimestamp']);
		$kdate = "";
		if (($this->config('eq2progress_date')) == TRUE ) 		{ ($stamp = date('m/d/Y', $achieve[$a]['completedtimestamp']));  
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
		if ($acid == '3780034671') {$malice6 = $malice6 + 1; $malice61 =$kdate.'<font color="808080"><strike>Ritual Keeper V\'derin</strike></font><br>';}
		if ($acid == '2521428217') {$malice6 = $malice6 + 1; $malice62 =$kdate.'<font color="808080"><strike>Tserrina Syl\'tor</strike></font><br>';}
		if ($acid == '116845928')  {$malice6 = $malice6 + 1; $malice63 =$kdate.'<font color="808080"><strike>Construct of Malice</strike></font><br>';}
		//Altar of Malice Avatars - The Precipice of Power
		if ($acid == '3312622728') {$aoma = $aoma + 1; $aoma1 =$kdate.'<font color="808080"><strike>Cazic-Thule</strike></font><br>';}
		if ($acid == '1264497483') {$aoma = $aoma + 1; $aoma2 =$kdate.'<font color="808080"><strike>Fennin Ro</strike></font><br>';}
		if ($acid == '2302657105') {$aoma = $aoma + 1; $aoma3 =$kdate.'<font color="808080"><strike>Karana</strike></font><br>';}
		if ($acid == '3211824092') {$aoma = $aoma + 1; $aoma4 =$kdate.'<font color="808080"><strike>The Tribunal</strike></font><br>';}
		//Far Seas Distillery
		if ($acid == '615137073') {$fsd = $fsd + 1; $fsd1 =$kdate.'<font color="808080"><strike>Brutas the Imbiber</strike></font><br>';}
		if ($acid == '3399769629') {$fsd = $fsd + 1; $fsd2 =$kdate.'<font color="808080"><strike>Captain Mergin</strike></font><br>';}
		if ($acid == '1403850663')  {$fsd = $fsd + 1; $fsd3 =$kdate.'<font color="808080"><strike>Swabber Rotgut</strike></font><br>';}
		if ($acid == '3134106258') {$fsd = $fsd + 1; $fsd4 =$kdate.'<font color="808080"><strike>Bull McCleran</strike></font><br>';}
		if ($acid == '3452541444') {$fsd = $fsd + 1; $fsd5 =$kdate.'<font color="808080"><strike>Charanda</strike></font><br>';}
		if ($acid == '1475875915') {$fsd = $fsd + 1; $fsd6 =$kdate.'<font color="808080"><strike>Kildiun the Drunkard</strike></font><br>';}
		if ($acid == '600308520') {$fsd = $fsd + 1; $fsd7 =$kdate.'<font color="808080"><strike>Pirate Shaman Snaggletooth</strike></font><br>';}
		if ($acid == '1421921214') {$fsd = $fsd + 1; $fsd8 =$kdate.'<font color="808080"><strike>Brunhildre the Wench</strike></font><br>';}
		if ($acid == '3011045049') {$fsd = $fsd + 1; $fsd9 =$kdate.'<font color="808080"><strike>Danacio the Witchdoctor</strike></font><br>';}
		if ($acid == '3296712239') {$fsd = $fsd + 1; $fsd10=$kdate.'<font color="808080"><strike>Baz the Illusionist</strike></font><br>';}
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
						   $aoma1,$aoma2,$aoma3,$aoma4,$aoma,
						   $malice11,$malice12,$malice13,$malice14,$malice1,
						   $malice21,$malice22,$malice23,$malice2,
						   $malice31,$malice32,$malice33,$malice3,
						   $malice41,$malice42,$malice43,$malice44,$malice45,$malice4,
						   $malice51,$malice52,$malice53,$malice54,$malice55,$malice5,
						   $malice61,$malice62,$malice63,$malice6,
						   $fsd1,$fsd2,$fsd3,$fsd4,$fsd5,$fsd6,$fsd7,$fsd8,$fsd9,$fsd10,$fsd
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
        $aomavatar = ($killslist[134].$killslist[135].$killslist[136].$killslist[137]);
		$zonetotal17 = ($killslist[138]);
		$mal1 = ($killslist[139].$killslist[140].$killslist[141].$killslist[142]);
		 $zonetotal18 = ($killslist[143]);
		$mal2 = ($killslist[144].$killslist[145].$killslist[146]);
		$zonetotal19 = ($killslist[147]);
		$mal3 = ($killslist[148].$killslist[149].$killslist[150]);
		$zonetotal20 = ($killslist[151]);
		$mal4 = ($killslist[152].$killslist[153].$killslist[154].$killslist[155].$killslist[156]);
		$zonetotal21 = ($killslist[157]);
		$mal5 = ($killslist[158].$killslist[159].$killslist[160].$killslist[161].$killslist[162]);
		$zonetotal22 = ($killslist[163]);
		$mal6 = ($killslist[164].$killslist[165].$killslist[166]);
		$zonetotal23 = ($killslist[167]);
		$fsdbb = ($killslist[168].$killslist[169].$killslist[170].$killslist[171].$killslist[172].$killslist[173].$killslist[174].$killslist[175].$killslist[176].$killslist[177]);
		$zonetotal24 = ($killslist[178]);
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
		$out = '';
			for($i=1;$i<=24;$i++) {
			$check = ${"zone".$i};
			if ($check == TRUE) {
			$text = ${"zonename".$i}; $value = ${"zonetotal".$i}; $max = ${"zonemax".$i}; $tooltip = ${"zonetip".$i};	
			$out .= $this->bar_out($i,$value,$max,$text,$tooltip);
			} 
			}
			return $out;
		return $this->bar_out();
	}
		
	public function bar_out($num,$value,$max,$text,$tooltip) {
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
