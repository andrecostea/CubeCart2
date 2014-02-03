<div id="stats_sales" class="tab_content">
  <h3>{$LANG.statistics.title_sales}</h3>
  {if $DISPLAY_SALES}
  <form action="{$VAL_SELF}" method="post">
	<div>
	  <fieldset><legend>{$LANG.common.filter}</legend>
	    <select name="select[year]">
	    {foreach from=$YEARS item=year}><option value="{$year.value}" {$year.selected}>{$year.value}</option>{/foreach}
	    </select>
	    <select name="select[month]">
	    {foreach from=$MONTHS item=month}<option value="{$month.value}"{$month.selected}>{$month.title}{/foreach}
	    </select>
	    <select name="select[day]">
	    {foreach from=$DAYS item=day}<option value="{$day.value}"{$day.selected}>{$day.value}</option>{/foreach}
	    </select>
	    <input type="submit" value="{$LANG.common.go}" />
	  </fieldset>
	</div>
	<input type="hidden" name="token" value="{$SESSION_TOKEN}" />
  </form>
    <img src="cache/{$GRAPH.yearly}" alt="" />
    <img src="cache/{$GRAPH.monthly}" alt="" />
	<img src="cache/{$GRAPH.daily}" alt="" />
	<img src="cache/{$GRAPH.hourly}" alt="" />
  {else}
  <p>{$LANG.statistics.notify_sales_none}</p>
  {/if}
</div>

{if isset($PRODUCT_SALES)}
<div id="stats_prod_sales" class="tab_content">
  <h3>{$LANG.statistics.title_popular}</h3>
  <div>
	<img src="cache/{$GRAPH_IMAGE_SALES}" alt="" />
  </div>
  <div>{$PAGINATION_SALES}</div>
 <table class="list">
	<thead>
	  <tr>
		<td width="20">&nbsp;</td>
		<td>{$LANG.catalogue.product_name}</td>
		<td width="130">{$LANG.statistics.quantity_sold}</td>
		<td width="150">{$LANG.statistics.percentage_of_total}</td>
	  </tr>
	</thead>
	<tbody>
	  {foreach from=$PRODUCT_SALES item=sale}
	  <tr>
		<td align="center">{$sale.key}</td>
		<td>{$sale.name}</td>
		<td>{$sale.quan}</td>
		<td>{$sale.percent}</td>
	  </tr>
	  {/foreach}
	<tbody>
  </table>
</div>
{/if}

{if isset($PRODUCT_VIEWS)}
<div id="stats_prod_views" class="tab_content">
  <h3>{$LANG.statistics.title_viewed}</h3>
  <div>
	<img src="cache/{$GRAPH_IMAGE_VIEWS}" alt="" />
  </div>
  <div>{$PAGINATION_VIEWS}</div>
  <table class="list">
	<thead>
	  <tr>
		<td width="20">&nbsp;</td>
		<td>{$LANG.catalogue.product_name}</td>
		<td width="130">{$LANG.statistics.product_views}</td>
		<td width="150">{$LANG.statistics.percentage_of_views}</td>
	  </tr>
	</thead>
	<tbody>
	  {foreach from=$PRODUCT_VIEWS item=view}
	  <tr>
		<td align="center">{$view.key}</td>
		<td>{$view.name}</td>
		<td>{$view.popularity}</td>
		<td>{$view.percent}</td>
	  </tr>
	  {/foreach}
	<tbody>
  </table>
</div>
{/if}

{if isset($SEARCH_TERMS)}
<div id="stats_search" class="tab_content">
  <h3>{$LANG.statistics.title_search}</h3>
  <div>
	<img src="cache/{$GRAPH_IMAGE_SEARCH}" alt="" />
  </div>
  <div>{$PAGINATION_SEARCH}</div>
  <table class="list">
	<thead>
	  <tr>
		<td width="20">&nbsp;</td>
		<td>{$LANG.statistics.search_term}</td>
		<td width="130">{$LANG.statistics.product_hits}</td>
		<td width="150">{$LANG.statistics.percentage_of_search}</td>
	  </tr>
	</thead>
	<tbody>
	  {foreach from=$SEARCH_TERMS item=term}
	  <tr>
		<td align="center">{$term.key}</td>
		<td>{$term.searchstr}</td>
		<td>{$term.hits}</td>
		<td>{$term.percent}</td>
	  </tr>
	  {/foreach}
	<tbody>
  </table>
</div>
{/if}

{if isset($BEST_CUSTOMERS)}
  <div id="stats_best_customers" class="tab_content">
  <h3>{$LANG.statistics.title_customers_best}</h3>
  <div>
	<img src="cache/{$GRAPH_IMAGE_BEST}" alt="" />
  </div>
  <div>{$PAGINATION_BEST}</div>
  <table class="list">
	<thead>
	  <tr>
		<td width="20">&nbsp;</td>
		<td>{$LANG.common.name}</td>
		<td width="130">{$LANG.statistics.total_expenditure}</td>
		<td width="150">{$LANG.statistics.percentage_of_total}</td>
	  </tr>
	</thead>
	<tbody>
	  {foreach from=$BEST_CUSTOMERS item=customer}
	  <tr>
		<td align="center">{$customer.key}</td>
		<td>{$customer.title} {$customer.first_name} {$customer.last_name}</td>
		<td>{$customer.expenditure}</td>
		<td>{$customer.percent}</td>
	  </tr>
	  {/foreach}
	<tbody>
  </table>
  </div>
  {/if}

  {if isset($USERS_ONLINE)}
  <div id="stats_online" class="tab_content">
  <h3>{$LANG.statistics.title_customers_active}</h3>
  <table class="list">
	<thead>
	  <tr>
		<td>{$LANG.statistics.session_admin}</td>
		<td>{$LANG.statistics.session_user}</td>
		<td>{$LANG.statistics.session_location}</td>
		<td>{$LANG.statistics.session_started}</td>
		<td>{$LANG.statistics.session_last}</td>
		<td>{$LANG.statistics.session_length}</td>
	  </tr>
	</thead>
	<tbody>
	{foreach from=$USERS_ONLINE item=user}
	  <tr>
		<td align="center"><img src="{$SKIN_VARS.admin_folder}/skins/{$SKIN_VARS.skin_folder}/images/{$user.is_admin}.png" /></td>
		<td>
		  <strong>{$user.name}</strong>
		  {if !empty($user.ip_address)}
		  <br />
		  [<a href="http://api.hostip.info/get_html.php?ip={$customer.ip_address}&amp;position=true" class="colorbox hostip">{$user.ip_address}</a>]
		  {/if}
		</td>
		<td>{$user.location} <a href="{$user.location}" target="_blank">&raquo;</a></td>
		<td align="center">{$user.session_start}</td>
		<td align="center"	>{$user.session_last}</td>
		<td>{$user.session_length}</td>
	  </tr>
	{/foreach}
	</tbody>
  </table>
  </div>
 {/if}