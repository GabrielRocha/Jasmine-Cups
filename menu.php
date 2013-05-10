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

  /* Menu.php: Displays the main menu */
       
       
?>    <div class="menu">
      <h2>Menu</h2>
      <ul>
        <li id="menu_general">
	  <a href="index.php" title="Mostra a página principal">
			<span title="Página principal">Principal</span>
		</a>
       <!--   <ul>
            <li>
              <a href="index.php" title="Display the main page">Main page</a>
            </li>
	    <li>
	      <a href="index.php?section=help" title="Get some help using JASmine">Help</a>
	    </li>
          </ul>
					-->
	</li>
        <li id="menu_reports">
          <span title="˜Relátorio">Relatório</span>
          <ul>
            <li>
              <a href="index.php?section=summary" title="Mostra o índicie">Índice</a>
            </li>
          </ul>
        </li>
	<li id="menu_find">
          <span title="Localiza Usuários e Impressoras">Procurar</span>
          <ul>
            <li>
              <a href="index.php?section=find&amp;searchType=printer" title="Localizar impressora">Impressoras</a>
            </li>
	    <li>
              <a href="index.php?section=find&amp;searchType=user" title="Localizar usuário">Usuários</a>
            </li>
						<li>
              <a href="index.php?section=find&amp;searchType=host" title="Localizar um IP">IP</a>
            </li>
            <!--<li>
              <a href="index.php?section=find&amp;searchType=server" title="Find a server">Servers</a>
            </li>
						-->
          </ul>
        </li>
      </ul>
    </div>
