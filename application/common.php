<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function stremjio($str = ':jinya:你你你你年份#qq_44##qq_25#'){
	$iconsGroup = [
		[
			'path' =>'/static/emoji/dist/img/tieba/',
			'file' =>'.jpg',
			'placeholder' => ':{alias}:',
		],
		[
			'path' =>'/static/emoji/dist/img/qq/',
			'file' =>'.gif',
			'placeholder' => '#qq_{alias}#',
		]
	];
	$alias = [1 => "hehe",2 => "haha",3 => "tushe",4 => "a",5 => "ku",6 => "lu",7 => "kaixin",8 => "han",9 => "lei",10 => "heixian",11 => "bishi",12 => "bugaoxing",13 => "zhenbang",14 => "qian",15 => "yiwen",16 => "yinxian",17 => "tu",18 => "yi",19 => "weiqu",20 => "huaxin",21 => "hu",22 => "xiaonian",23 => "neng",24 => "taikaixin",25 => "huaji",26 => "mianqiang",27 => "kuanghan",28 => "guai",29 => "shuijiao",30 => "jinku",31 => "shengqi",32 => "jinya",33 => "pen",34 => "aixin",35 => "xinsui",36 => "meigui",37 => "liwu",38 => "caihong",39 => "xxyl",40 => "taiyang",41 => "qianbi",42 => "dnegpao",43 => "chabei",44 => "dangao",45 => "yinyue",46 => "haha2",47 => "shenli",48 => "damuzhi",49 => "ruo",50 => "OK"];
	
	foreach($iconsGroup as $val){
		preg_match_all("/^:[a-z]:$/", $str, $match);
		print_r($match[0]);
	}
}