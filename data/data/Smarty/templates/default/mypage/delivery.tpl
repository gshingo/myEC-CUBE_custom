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
        <h3><img src="<!--{$TPL_URLPATH}-->img/mypage/subtitle03.gif" width="515" height="32" alt="お届け先追加・変更" /></h3>
        <p class="inforamtion">登録住所以外へのご住所へ送付される場合等にご利用いただくことができます。<br />
        ※最大<span class=""><!--{$smarty.const.DELIV_ADDR_MAX|h}-->件</span>まで登録できます。</p>

        <!--{if $tpl_linemax < $smarty.const.DELIV_ADDR_MAX}-->
            <!--{* 退会時非表示 *}-->
            <!--{if $tpl_login}-->
                <p class="add_address">
                    <a href="<!--{$smarty.const.ROOT_URLPATH}-->mypage/delivery_addr.php" onclick="win03('./delivery_addr.php','delivadd','600','640'); return false;" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/common/newadress_on.gif','newadress');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/common/newadress.gif','newadress');" target="_blank"><img src="<!--{$TPL_URLPATH}-->img/common/newadress.gif" alt="新しいお届け先を追加" border="0" name="newadress" /></a>
                </p>
            <!--{/if}-->
        <!--{/if}-->

        <!--{if $tpl_linemax > 0}-->
        <form name="form1" method="post" action="?" >
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <input type="hidden" name="mode" value="" />
            <input type="hidden" name="other_deliv_id" value="" />
            <input type="hidden" name="pageno" value="<!--{$tpl_pageno}-->" />

            <table summary="お届け先" class="delivname">
            <!--{*
            <col width="5%" />
            <col width="25%" />
            <col width="50%" />
            <col width="10%" />
            <col width="10%" />
            *}-->
                <tr>
                    <th class="alignC" colspan="5">▼お届け先</th>
                </tr>
                <!--{section name=cnt loop=$arrOtherDeliv}-->
                    <!--{assign var=OtherPref value="`$arrOtherDeliv[cnt].pref`"}-->
                    <tr>
                        <td class="alignC"><!--{$smarty.section.cnt.iteration}--></td>
                        <td><label for="add<!--{$smarty.section.cnt.iteration}-->">お届け先住所</label></td>
                        <td>
                            〒<!--{$arrOtherDeliv[cnt].zip01}-->-<!--{$arrOtherDeliv[cnt].zip02}--><br />
                            <!--{$arrPref[$OtherPref]|h}--><!--{$arrOtherDeliv[cnt].addr01|h}--><!--{$arrOtherDeliv[cnt].addr02|h}--><br />
                            <!--{$arrOtherDeliv[cnt].name01|h}-->&nbsp;<!--{$arrOtherDeliv[cnt].name02|h}-->
                        </td>
                        <td class="alignC">
                            <a href="./delivery_addr.php" onclick="win02('./delivery_addr.php?other_deliv_id=<!--{$arrOtherDeliv[cnt].other_deliv_id}-->','deliv_disp','600','640'); return false;">変更</a>
                        </td>
                        <td class="alignC">
                            <a href="#" onclick="fnModeSubmit('delete','other_deliv_id','<!--{$arrOtherDeliv[cnt].other_deliv_id}-->'); return false;">削除</a>
                        </td>
                    </tr>
                <!--{/section}-->
            </table>
        </form>
        <!--{else}-->
        <p class="delivempty"><strong>新しいお届け先はありません。</strong></p>
        <!--{/if}-->
    </div>
</div>
