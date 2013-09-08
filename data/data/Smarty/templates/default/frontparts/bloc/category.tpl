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
<script type="text/javascript">//<![CDATA[
    $(function(){
        $('#category_area li.level1:last').css('border-bottom', 'none');
    });
//]]></script>
<div class="block_outer">
    <div id="category_area">
        <div class="block_body">
            <h2><img src="<!--{$TPL_URLPATH}-->img/title/tit_bloc_category.gif" alt="商品カテゴリ" /></h2>
            <!--{strip}-->
                <ul id="categorytree">
                    <!--{assign var=preLev value=1}-->
                    <!--{assign var=firstdone value=0}-->
                    <!--{section name=cnt loop=$arrTree}-->
                        <!-- 表示フラグがTRUEなら表示 -->
                        <!--{if $arrTree[cnt].display == 1}-->
                            <!--{assign var=level value=`$arrTree[cnt].level`}-->
                            <!--{assign var=levdiff value=`$level-$preLev`}-->
                                <!--{if $levdiff > 0}-->
                                    <ul>
                                <!--{elseif $levdiff == 0 && $firstdone == 1}-->
                                    </li>
                                <!--{elseif $levdiff < 0}-->
                                    <!--{section name=d loop=`$levdiff*-1`}-->
                                            </li>
                                        </ul>
                                    <!--{/section}-->
                                    </li>
                                <!--{/if}-->
                            <li class="level<!--{$level}--><!--{if in_array($arrTree[cnt].category_id, $tpl_category_id)}--> onmark<!--{/if}-->">
                                <p>
                                    <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrTree[cnt].category_id}-->"<!--{if in_array($arrTree[cnt].category_id, $tpl_category_id)}--> class="onlink"<!--{/if}-->><!--{$arrTree[cnt].category_name|h}-->(<!--{$arrTree[cnt].product_count|default:0}-->)</a>
                                </p>
                            <!--{if $firstdone == 0}--><!--{assign var=firstdone value=1}--><!--{/if}-->
                            <!--{assign var=preLev value=`$level`}-->
                        <!--{/if}-->
                        <!-- セクションの最後に閉じタグを追加 -->
                        <!--{if $smarty.section.cnt.last}-->
                            <!--{if $preLev-1 > 0}-->
                                <!--{section name=d loop=`$preLev-1`}-->
                                    </li>
                                </ul>
                                <!--{/section}-->
                                </li>
                            <!--{else}-->
                                </li>
                            <!--{/if}-->
                        <!--{/if}-->
                    <!--{/section}-->
                </ul>
            <!--{/strip}-->
        </div>
    </div>
</div>
*}-->

<!--外装別ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="外装" />
    <div class="category_title">
        <span><strong>外装</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_gaisou}-->
        <!--{if $arrRet_gaisou[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_gaisou[cnt].category_id}-->"><!--{$arrRet_gaisou[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--外装別ここまで-->

<!--電飾別ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="電飾" />
    <div class="category_title">
        <span><strong>電飾</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_densyoku}-->
        <!--{if $arrRet_densyoku[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_densyoku[cnt].category_id}-->"><!--{$arrRet_densyoku[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--電飾別ここまで-->

<!--内装インテリア別ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="内装インテリア" />
    <div class="category_title">
        <span><strong>内装・インテリア</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_naisou}-->
        <!--{if $arrRet_naisou[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_naisou[cnt].category_id}-->"><!--{$arrRet_naisou[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--内装インテリア別ここまで-->

<!--ドライバー用品別ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="ドライバー用品" />
    <div class="category_title">
        <span><strong>ドライバー用品</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_driver}-->
        <!--{if $arrRet_driver[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_driver[cnt].category_id}-->"><!--{$arrRet_driver[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--ドライバー用品別ここまで-->

<!--車種別ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="車種別" />
    <div class="category_title">
        <span><strong>車種別</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_syasyu}-->
        <!--{if $arrRet_syasyu[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_syasyu[cnt].category_id}-->"><!--{$arrRet_syasyu[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--車種別ここまで-->

<!--業務用品ここから-->
<div class="topspace">
    <img src="<!--{$TPL_URLPATH}-->img/side/category_title.gif" width="220" height="27" alt="業務用品別" />
    <div class="category_title">
        <span><strong>業務用品</strong>から選ぶ</span>
    </div>
</div>
<div id="categoryarea">
    <!--{* 表示リスト取得 *}-->
    <!--{assign var=idx value=0}-->
    <!--{section name=cnt loop=$arrRet_gyoumu}-->
        <!--{if $arrRet_gyoumu[cnt].display == 1}-->
            <!--{if $idx > 0}-->
                <div class="spacer"></div>
                <!--{* 区切り線 *}-->
                <div class="breakline"><img src="<!--{$TPL_URLPATH}-->img/side/side_line.gif" width="200" height="1" alt="区切り線" /></div>
                <div class="spacer"></div>
            <!--{/if}-->
            <img src="<!--{$TPL_URLPATH}-->img/common/arrow.gif" width="5" height="6" alt="点" />
            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list/<!--{$arrRet_gyoumu[cnt].category_id}-->"><!--{$arrRet_gyoumu[cnt].category_name}--></a>            
            <br>
            <!--{assign var=idx value=$idx+1}-->
        <!--{/if}-->
    <!--{/section}-->
</div>
<!--業務用品ここまで-->

