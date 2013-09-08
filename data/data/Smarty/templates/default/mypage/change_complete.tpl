<!--{*
/*
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
 */
*}-->

<div id="mypagecolumn">
    <h2 class="title"><img src="<!--{$TPL_URLPATH}-->img/mypage/title.jpg" width="700" height="40" alt="MYページ" /></h2>
    <!--{include file=$tpl_navi}-->
    <div id="mycontents_area">
        <h3><img src="<!--{$TPL_URLPATH}-->img/mypage/subtitle02.gif" width="515" height="32" alt="会員登録内容変更" /></h3>

        <div id="complete_area">
            <div class="message">
                会員登録内容の変更が完了いたしました。<br />
            </div>
            <p>今後ともご愛顧賜りますようよろしくお願い申し上げます。</p>
        </div>
        <div class="btn_area">
            <a href="<!--{$smarty.const.TOP_URLPATH}-->" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back_on.gif','fortop');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/b_back.gif','fortop');"><img src="<!--{$TPL_URLPATH}-->img/common/b_back.gif" width="150" height="30" alt="TOPページへ" name="fortop" id="fortop" /></a>
        </div>
    </div>
</div>
