<? include_once("./_head.whitehole.php"); ?>

<?
include "../db_conn.php";
include "../functions.php";
?>

<?
$num=$_GET['num'];
$uuid=$_GET['uuid'];
$rule_name=$_GET['rule_name'];
$account=$_GET['account'];

@mysql_query("set autocommit=0");
@mysql_query("begin");

$query="delete from security_ruleset where num='$num'";
$result=@mysql_query($query);
if (!$result) {
    @mysql_query("rollback");
	alert_msg("[Error] 트랜잭션 실패 -> 모든 작업 롤백");
} else {
############
$path_nwfilter_xml="/home/mnt/sec/xml-nwfilter";
$security_group_uuid=$uuid;

$query_vm="select uuid,node from info_vm where security_group_uuid='$security_group_uuid' and status='1'";
$result_vm=@mysql_query($query_vm);
if (mysql_num_rows($result_vm)>0) {
        while ($data_vm=mysql_fetch_row($result_vm)) {
                $vm_uuid=$data_vm['0'];
                $target_node=$data_vm['1'];
include "include-apply_security_group.php";
        }
}
@mysql_query("commit");
############
    echo ("
        <script language=\"javascript\">
            location.href=\"edit_security_group.php?rule_name=$rule_name&uuid=$uuid&account=$account\"
        </script>
    ");
}
?>
