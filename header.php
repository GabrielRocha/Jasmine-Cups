<?php
/* JASmine, print accounting system for Cups.
 Copyright (C) Nayco.

 (Please read the COPYING file)

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. */

  // Do this here, to avoid problems with the php.ini "short_open_tags" directive...
	header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Relatório de Impressão Campus Bom Jesus do Itabapoana</title>
<!--[if IE]>
    <link rel="stylesheet" type="text/css" media="screen" href="style_oldbw.css" />
    <link rel="stylesheet" type="text/css" media="print" href="style_printer.css" />
<![endif]-->
    <style type="text/css">
      <!--
      @import "css/style.css" screen;
      @import "css/style_printer.css" print;
      -->
    </style>
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
		<!--<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>-->
		<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<script src="js/locale/grid.locale-pt-br.js" type="text/javascript"></script>
		<script src="js/jquery-ui.js" type="text/javascript"></script>
		<script src="js/jquery.layout.js" type="text/javascript"></script>
		<script src="js/jquery.jqGrid.src.js" type="text/javascript"></script>
		<script type='text/javascript'>
			$(function(){
				$(".header").click(function(){
					window.location="index.php";
					});
				$("table tbody tr:nth-child(even)").addClass("changecolor");
					
			});
		</script>
  </head>
  <body>
    	<div class="header">
      	<h1>IFF - Campus Bom Jesus do Itabapoana</h1>
      	<p>
        	<br><em>Relatório de Impressão</em>
      	</p>
    	</div>