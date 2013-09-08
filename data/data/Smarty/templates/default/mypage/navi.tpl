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

<div id="mynavi_area">
    <!--{strip}-->
        <ul class="mynavi_list clearfix">
            <!--{* 会員状態 *}-->
            <!--{if $tpl_login}-->
                <!--{assign var=index_url value=`$smarty.const.DIR_INDEX_PATH`}-->
                <!--{assign var=index_url value="./$index_url"}-->
                <!--{assign var=favorite_url value="favorite.php"}-->
                <!--{assign var=change_url value="change.php"}-->
                <!--{assign var=delivery_url value="delivery.php"}-->
                <!--{assign var=refusal_url value="refusal.php"}-->
            <!--{* 退会状態 *}-->
            <!--{else}-->
                <!--{assign var=index_url value=`$smarty.const.TOP_URLPATH`}-->
                <!--{assign var=favorite_url value=`$smarty.const.TOP_URLPATH`}-->
                <!--{assign var=change_url value=`$smarty.const.TOP_URLPATH`}-->
                <!--{assign var=delivery_url value=`$smarty.const.TOP_URLPATH`}-->
                <!--{assign var=refusal_url value=`$smarty.const.TOP_URLPATH`}-->
            <!--{/if}-->
            <li><a href="<!--{$index_url}-->" class="<!--{if $tpl_mypageno == 'index'}--> selected<!--{/if}-->">
                <img src="<!--{$TPL_URLPATH}-->img/mypage/navi01<!--{if $tpl_mypageno == 'index'}-->_on<!--{/if}-->.jpg"
                     width="170" height="30" alt="購入履歴一覧" border="0" name="m_navi01"
                     <!--{if $tpl_mypageno != 'index'}-->
                     onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi01_on.jpg','m_navi01');"
                     onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi01.jpg','m_navi01');"
                     <!--{/if}-->
                />
            </a></li>
            <!--{if $smarty.const.OPTION_FAVORITE_PRODUCT == 1}-->
                <li><a href="<!--{$favorite_url}-->" class="<!--{if $tpl_mypageno == 'favorite'}--> selected<!--{/if}-->">
                    <img src="<!--{$TPL_URLPATH}-->img/mypage/navi05<!--{if $tpl_mypageno == 'favorite'}-->_on<!--{/if}-->.jpg"
                         width="170" height="30" alt="お気に入り商品一覧" border="0" name="m_navi05"
                         <!--{if $tpl_mypageno != 'favorite'}-->
                         onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi05_on.jpg','m_navi05');"
                         onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi05.jpg','m_navi05');"
                         <!--{/if}-->
                    />
                </a></li>
            <!--{/if}-->
            <li><a href="<!--{$change_url}-->" class="<!--{if $tpl_mypageno == 'change'}--> selected<!--{/if}-->">
                <img src="<!--{$TPL_URLPATH}-->img/mypage/navi02<!--{if $tpl_mypageno == 'change'}-->_on<!--{/if}-->.jpg"
                     width="170" height="30" alt="会員登録内容変更" border="0" name="m_navi02"
                     <!--{if $tpl_mypageno != 'change'}-->
                     onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi02_on.jpg','m_navi02');"
                     onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi02.jpg','m_navi02');"
                     <!--{/if}-->
                />
            </a></li>
            <li><a href="<!--{$delivery_url}-->" class="<!--{if $tpl_mypageno == 'delivery'}--> selected<!--{/if}-->">
                <img src="<!--{$TPL_URLPATH}-->img/mypage/navi03<!--{if $tpl_mypageno == 'delivery'}-->_on<!--{/if}-->.jpg"
                     width="170" height="30" alt="お届け先追加・変更" border="0" name="m_navi03"
                     <!--{if $tpl_mypageno != 'delivery'}-->
                     onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi03_on.jpg','m_navi03');"
                     onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi03.jpg','m_navi03');"
                     <!--{/if}-->
                />
            </a></li>
            <li><a href="<!--{$refusal_url}-->" class="<!--{if $tpl_mypageno == 'refusal'}--> selected<!--{/if}-->">
                <img src="<!--{$TPL_URLPATH}-->img/mypage/navi04<!--{if $tpl_mypageno == 'refusal'}-->_on<!--{/if}-->.jpg"
                     width="170" height="30" alt="退会手続き" border="0" name="m_navi04"
                     <!--{if $tpl_mypageno != 'refusal'}-->
                     onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi04_on.jpg','m_navi04');"
                     onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/mypage/navi04.jpg','m_navi04');"
                     <!--{/if}-->
                />
            </a></li>
        </ul>

        <!--▼現在のポイント-->
        <!--{if $point_disp !== false}-->
            <div class="point_announce clearfix">
                <p>ようこそ<br />
                    <span class="user_name"><!--{$CustomerName1|h}--> <!--{$CustomerName2|h}-->様</span>
                    <!--{if $smarty.const.USE_POINT !== false}-->
                        <br />現在の所持ポイントは<span class="point st"><!--{$CustomerPoint|number_format|default:"0"|h}-->pt</span>&nbsp;です。
                    <!--{/if}-->
                </p>
            </div>
        <!--{/if}-->
        <!--▲現在のポイント-->
        <div class="point_system">
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/utility.php#pointsystem">ポイントシステムについて</a>
        </div>
    <!--{/strip}-->

</div>
<!--▲NAVI-->
