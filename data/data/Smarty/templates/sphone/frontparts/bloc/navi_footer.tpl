<!--{*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2012 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->
<!--{*
<ul class="footer_navi">
    <!--{if $tpl_login}-->
        <li><a rel="external" href="<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/mypage/login.php"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_mypage_off.png" alt="MYページ" width="75" height="50" /></a></li>
        <li><a rel="external" href="<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/mypage/favorite.php"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_favorite_off.png" alt="お気に入り" width="75" height="50" /></a></li>
    <!--{else}-->
        <li><a data-transition="slideup" href="<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/mypage/login.php"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_mypage_off.png" alt="MYページ" width="75" height="50" /></a></li>
        <li><a data-transition="slideup" href="<!--{$smarty.const.HTTPS_URL|sfTrimURL}-->/mypage/login.php"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_favorite_off.png" alt="お気に入り" width="75" height="50" /></a></li>
    <!--{/if}-->
    <li><a rel="external" href="<!--{$smarty.const.CART_URLPATH|h}-->"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_cart_off.png" alt="カゴの中を見る" width="75" height="50" /></a></li>
    <li><a rel="external" href="<!--{$smarty.const.ROOT_URLPATH}-->"><img src="<!--{$TPL_URLPATH}-->img/button/btn_footer_toppage_off.png" alt="トップページへ" width="75" height="50" /></a></li>
</ul>
*}-->
<nav id="utilities">
    <ul>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=sendprice" data-ajax="false">送料について</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=pay">お支払いについて</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=delivery">配送について</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=products_send">納品について</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=sendback">返品交換について</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=pointsystem">ポイントシステムについて</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=support">サポートについて</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=company">会社概要</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=kojin">個人情報保護方針</a></li>
        <li><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php?doc=tokutei">特定商取引法に関する表記</a></li>
    </ul>
</nav>
