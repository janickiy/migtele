<?
require('inc/common.php');
$tbl = "ip_managers";
$rubric = "Слайды";
$id = (int)@$_GET['id'];

$start = isset($_GET['start']) ? $_GET['start'] : '';
$end = isset($_GET['end']) ? $_GET['end'] : '';
$ip_manager_ids = isset($_GET['ip_manager_ids']) ? $_GET['ip_manager_ids'] : '';

$sqlmain = "SELECT * FROM {$prx}{$tbl} ORDER BY id DESC";
$k = 40;

// -------------------СОХРАНЕНИЕ----------------------
if(isset($_GET["action"]))
{
    switch($_GET['action'])
    {
        case "save":

            foreach ($_POST['managers'] as $id=>$manager)
            {
                update($tbl, "name='{$manager['name']}'", $id);
            }

            ?><script>top.location.href = "/admin/ip_managers.php";</script><?
            break;

        case "del":

            break;
    }
    exit;
}

ob_start();
// ------------------РЕДАКТИРОВАНИЕ--------------------
if(isset($_GET["red"]))
{

}

// -----------------ПРОСМОТР-------------------
else
{
    ?>
    <form action="?action=save" method="post">

        <table class="content">
            <tr>
                <th></th>
                <th>IP</th>
                <th>Имя</th>
                <th></th>
            </tr>
            <?



            $res = sql($sqlmain);
            while($row = mysql_fetch_array($res))
            {
                $id = $row["id"];
                ?>
                <tr id="tr<?=$id?>">
                    <td><input type="checkbox" <?= in_array($row["id"], explode(',', $ip_manager_ids)) ? 'checked' : '' ?> class="manager-checked" value="<?=$row["id"]?>"></td>
                    <td><?=$row["ip"]?></td>
                    <td><input type="text" name="managers[<?=$row["id"]?>][name]" value="<?=$row["name"]?>"></td>
                    <td><button class="select-manager" data-id="<?=$row['id']?>" type="button">Выбрать</button></td>
                </tr>
            <?	}	?>
            <tr>
                <th colspan="4" style="text-align:center; border:none; "><button class="select-managers" type="button">Выбрать выделенных</button>&nbsp;<input value="Сохранить имена" type="submit">&nbsp;</th>
            </tr>
        </table>

    </form>


    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.12.4.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <form action="" method="get" id="logs-form">
        <input type="hidden" name="ip_manager_ids" value="<?=$ip_manager_ids?>">
        <table class="content">
            <tr>
                <th>
                    <div align="left">За период
                        <input class="datepicker" type="text" name="start" value="<?=$start?>" style="margin-left:10px; width:200px;">
                        <input class="datepicker" type="text" name="end" value="<?=$end?>" style="margin-left:10px; width:200px;">

                        <?
                        $buttons = [
                            [
                                'title' => 'За сегодня',
                                'start' => date('Y-m-d'),
                                'end' => date('Y-m-d')
                            ],
                            [
                                'title' => 'За вчера',
                                'start' => date('Y-m-d', strtotime('now -1days')),
                                'end' => date('Y-m-d', strtotime('now -1days'))
                            ],
                            [
                                'title' => 'За неделю',
                                'start' => date('Y-m-d', strtotime('last Monday')),
                                'end' => date('Y-m-d')
                            ],
                            [
                                'title' => 'За месяц',
                                'start' => date('Y-m-01'),
                                'end' => date('Y-m-d')
                            ]
                        ];

                        foreach ($buttons as $button)
                        {
                            ?><button class="js-set-date" data-start="<?=$button['start']?>" data-end="<?=$button['end']?>"><?=$button['title']?></button> <?
                        }
                        ?>
                    </div>
                </th>
            </tr>
            <tr>
                <th colspan="4" style="text-align:center; border:none; ">&nbsp;<input value="Показать" type="submit" style="width:80px;">&nbsp;</th>
            </tr>
        </table>
    </form>

    <script>
        $( ".datepicker" ).datepicker({dateFormat: "yy-mm-dd"});

        $('.js-set-date').click(function(e){
            e.preventDefault();
            $('.datepicker[name="start"]').val($(this).data('start'));
            $('.datepicker[name="end"]').val($(this).data('end'));
        });

        var $ip_manager_ids = $('input[name="ip_manager_ids"]');

        $('.select-manager').click(function () {

            var id = $(this).data('id');

            $ip_manager_ids.val(id);

            logFormSubmit();

        });

        $('.select-managers').click(function () {

            var ids = [];

            $('.manager-checked:checked').each(function () {

                ids.push($(this).val());

            });

            $ip_manager_ids.val(ids.join());


            logFormSubmit();
        });



        function logFormSubmit() {
            $('#logs-form').submit();
        }

    </script>



    <table class="content">
        <tr>
            <th>Ссылка на товар</th>
            <th>Дата входа</th>
            <th>Дата выхода</th>
            <th>Время в товаре</th>
            <th>IP адрес</th>
        </tr>
        <?

        $where = 'WHERE 1=1';
        $table = "{$prx}ip_manager_logs as l";

        if($start){
            $where .= " AND '{$start} 00:00:00' <= l.start";
        }

        if($end){
            $where .= " AND '{$end} 23:59:59' >= l.end";
        }

        if($ip_manager_ids)
        {
            $where .= " AND l.ip_manager_id in ({$ip_manager_ids})";
        }

        $sqlmain = "SELECT l.id, l.start, l.end, concat(m.ip, ' ', IFNULL(m.name, ' ')) as manager, TIMESTAMPDIFF(SECOND, l.start, l.end) as diff   
                FROM {$table}
                LEFT JOIN {$prx}ip_managers as m ON l.ip_manager_id = m.id                
                {$where}";

        $sql = $sqlmain . " ORDER BY l.id DESC";

        $k = 500;

        $p = @$_GET['p'] ? $_GET['p'] : 1;
        $res = sql($sql." LIMIT ".($p-1)*$k.", {$k}");

        $logs = [];

        while($row = mysql_fetch_array($res))
        {
            $logs[] = $row;
        }


        foreach($logs as $row)
        {
            $id = $row["id"];

            $products_res = sql("SELECT p.name as product_name, p.link as product_link
                                 FROM {$prx}ip_manager_log_product as lp
                                 LEFT JOIN {$prx}goods as p ON lp.product_id = p.id 
                                 WHERE lp.ip_manager_log_id='{$id}'")


            ?>

            <tr id="tr<?=$id?>">
                <td>
                    <?php $i = 0; ?>
                    <?php while($product = mysql_fetch_array($products_res)){ ?>
                        #<?=++$i?> <a href="/tovar/<?=$product["product_link"]?>.htm" target="_blank"><?=$product["product_name"]?></a><br>
                    <?php } ?>
                </td>
                <td><?=$row["start"]?></td>
                <td><?=$row["end"]?></td>
                <td><?=pretty_time_passed($row['diff'])?></td>
                <td><?=$row["manager"]?></td>
            </tr>
        <?	}	?>
        <tr>
            <td colspan="4" align="center"><?=lnkPages($sql, $p, $k)?></td>
        </tr>
    </table>


    <?php

    $statistics = getRow("SELECT 
                              SUM(TIMESTAMPDIFF(SECOND, l.start, l.end)) as sum,
                              AVG(TIMESTAMPDIFF(SECOND, l.start, l.end)) as avg,
                              MAX(TIMESTAMPDIFF(SECOND, l.start, l.end)) as max,
                              MIN(TIMESTAMPDIFF(SECOND, l.start, l.end)) as min
                              FROM {$table} {$where}");

    $product_count = getField("SELECT COUNT(p.id) as count
                             FROM {$table}
                             LEFT JOIN {$prx}ip_managers as m ON l.ip_manager_id = m.id
                             LEFT JOIN {$prx}ip_manager_log_product as p ON p.ip_manager_log_id = l.id
                            {$where}
    ")

    ?>

    <h3>Статистика за выбранную дату</h3>
    <table class="content">
        <tr>
            <th>Количество товаров отредактировано:</th>
            <td><strong><?=$product_count?></strong></td>
        </tr>
        <tr>
            <th>Общеее время потрачено: </th>
            <td><strong><?=pretty_time_passed($statistics['sum'])?></strong></td>
        </tr>
        <tr>
            <th>Среднее время на редактирование одного товара: </th>
            <td><strong><?=pretty_time_passed($statistics['avg'])?></strong></td>
        </tr>
        <tr>
            <th>Максимальное время на редактирования товара: </th>
            <td><strong><?=pretty_time_passed($statistics['max'])?></strong></td>
        </tr>
        <tr>
            <th>Минимальное время на редактирования товара: </th>
            <td><strong><?=pretty_time_passed($statistics['min'])?></strong></td>
        </tr>
    </table>

    <?
}

function pretty_time_passed($seconds)
{
    $minute = floor($seconds / 60);
    $seconds = $seconds % 60;
    $hours = '';

    if($minute > 59){
        $hours = floor($minute / 60);
        $minute = $minute % 60;

        $hours = $hours . ' часов ';
    }

    return $hours . $minute.' минут '.$seconds.' секунд';
}

$content = ob_get_clean();

require("template.php");
?>