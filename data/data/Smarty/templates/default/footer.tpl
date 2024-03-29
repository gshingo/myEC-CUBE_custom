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

<!--▼FOOTER-->
<div id="footer_wrap">
    <div id="footer" class="clearfix">
        <div id="pagetop">
            <a href="#top"><img width="150" height="25" id="top_back" name="top_back" alt="TOP戻る" src="<!--{$TPL_URLPATH}-->img/common/back_top_btn.gif"></a>
        </div>
        <!--{if $smarty.session.pc_from_sphone == 1}-->
            <p>表示：<strong>PC</strong> ｜ <a href="<!--{$smarty.const.ROOT_URLPATH}-->?pc_from_sphone=0">スマートフォン</a></p>
        <!--{/if}-->
        <div id="copyright">
             <div id="copyright_img">
                 <img width="250" height="18" id="corp" name="corp" alt="corp" src="<!--{$TPL_URLPATH}-->img/footer/corp.gif">
             </div>
<!--{*
Copyright ©
            <!--{if $smarty.const.RELEASE_YEAR != $smarty.now|date_format:"%Y"}--><!--{$smarty.const.RELEASE_YEAR}-->-<!--{/if}--><!--{$smarty.now|date_format:"%Y"}-->
            <!--{$arrSiteInfo.shop_name_eng|default:$arrSiteInfo.shop_name|h}--> All rights reserved.
*}-->
        </div>
    </div>
</div>
<!--▲FOOTER-->