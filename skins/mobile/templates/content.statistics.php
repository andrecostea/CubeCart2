<div id="user_stats">
	<h2>{$LANG.user_statistics.personal_info}</h2>
		<p>{$LANG.user_statistics.last_login}{$STATISTICS.prev_login_date} (IP: {$STATISTICS.prev_login_ip})</p>
		<p>&nbsp;&nbsp;{$LANG.user_statistics.last_bought} {$STATISTICS.prev_transaction}</p>
		<p>&nbsp;&nbsp;{$LANG.user_statistics.users_same_country}: {$STATISTICS.users_from_same_country}</p>
	<br />
	<br />
	<h2>{$LANG.user_statistics.general_info}</h2>
		<p>{$LANG.user_statistics.online_users} {$STATISTICS.online_users}</p>
		<br />
		<!--<img src="classes/chartcountry.php">-->
		<p>&nbsp;&nbsp;{$LANG.user_statistics.users_country}:</p>
		<img src={$STATISTICS.cchart}>
		<br />
		<p>&nbsp;&nbsp;{$LANG.user_statistics.users_traffic}:</p>
		<img src={$STATISTICS.uchart}>
		<!-- <img src="pielabelsex5.php"> -->
</div>
