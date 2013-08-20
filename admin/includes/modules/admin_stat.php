<?php
/* -----------------------------------------------------------------
 * 	$Id: admin_stat.php 420 2013-06-19 18:04:39Z akausch $
 * 	Copyright (c) 2011-2021 commerce:SEO by Webdesign Erfurt
 * 	http://www.commerce-seo.de
 * ------------------------------------------------------------------
 * 	based on:
 * 	(c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
 * 	(c) 2002-2003 osCommerce - www.oscommerce.com
 * 	(c) 2003     nextcommerce - www.nextcommerce.org
 * 	(c) 2005     xt:Commerce - www.xt-commerce.com
 * 	Released under the GNU General Public License
 * --------------------------------------------------------------- */

defined("_VALID_XTC") or die("Direct access to this location isn't allowed.");

define('DIR_WS_GRAPHS', DIR_WS_IMAGES . 'graphs/');
define('DB_CACHE', FALSE);
define('EXT', 'png');

include(DIR_WS_CLASSES . 'phplot.php');

$day = date('d', time());
$year = date('Y', time());
$month = date('m', time());
$month_long = date('M', time());

function xtc_get_image_graph($image_info) {
    if (xtc_not_null($image_info)) {
        if (file_exists($image_info['image'])) {
            return '<img src="' . $image_info['image'] . '" border="0" width="' . $image_info['width'] . '" height="' . $image_info['height'] . '" alt="" </img>';
        } else {
            return 'no gant - image found: <i>' . $image_info['image'] . '</i>';
        }
    } else {
        return '<b>ERROR: undifined object</b>';
    }
}

function xtc_find_title($array, $title) {
    $array_element = false;
    if (xtc_not_null($array)) {
        for ($c = 0; $c < sizeof($array); $c++) {
            $element = $array[$c];
            if ($element['title'] == $title) {
                $array_element = $element;
                break;
            }
        }
    }
    return $array_element;
}

/* check weather dir is writeable */
$dir_ok = false;
if ((function_exists('imagecreate'))) {
    if (is_dir(DIR_WS_GRAPHS)) {
        if (is_writeable(DIR_WS_GRAPHS)) {
            $dir_ok = true;
        } else {
            $messageStack->add(ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE, 'error');
        }
    } else {
        $messageStack->add(ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST, 'error');
    }
}

/* define size and image name for all gants  */
$month_gant_info = array(
    'name' => 'month',
    'width' => 600,
    'height' => 400,
    'image' => DIR_WS_GRAPHS . 'month_gant.' . EXT,
    'title' => sprintf(TABLE_HEADING_MONTH, $month_long . '/' . $year),
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                     day AS title FROM " .
            TABLE_ADMIN_STAT_MONTH . "
                     GROUP BY title 
                     ORDER BY title ASC"),
);
$month_ref_gant_info = array(
    'name' => 'month_ref',
    'width' => 400,
    'height' => 300,
    'image' => DIR_WS_GRAPHS . 'month_ref_gant.' . EXT,
    'title' => sprintf(TABLE_HEADING_MONTHLY_TOP, $month_long . '/' . $year),
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                      referer_url AS title FROM " .
            TABLE_ADMIN_STAT_MONTH . " 
                      GROUP BY title 
                      ORDER BY value DESC LIMIT 10")
);
$year_gant_info = array(
    'name' => 'year',
    'width' => 400,
    'height' => 400,
    'image' => DIR_WS_GRAPHS . 'year_gant.' . EXT,
    'title' => sprintf(TABLE_HEADING_YEAR, $year),
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                      year, month AS title FROM " .
            TABLE_ADMIN_STAT_YEAR . "
                      GROUP BY title 
                      HAVING year = '" . $year . "' 
                      ORDER BY title ASC")
);
$year_ref_gant_info = array(
    'name' => 'year_ref',
    'width' => 400,
    'height' => 300,
    'image' => DIR_WS_GRAPHS . 'year_ref_gant.' . EXT,
    'title' => sprintf(TABLE_HEADING_YEARLY_TOP, $year),
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                       referer_url AS title, count FROM " .
            TABLE_ADMIN_STAT_YEAR . " 
                       WHERE year = " . $year . " 
                       GROUP BY title
                       ORDER BY value DESC LIMIT 10")
);

$total_gant_info = array(
    'name' => 'total',
    'width' => 400,
    'height' => 400,
    'image' => DIR_WS_GRAPHS . 'total_gant.' . EXT,
    'title' => TABLE_HEADING_TOTAL_YEAR,
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                      year AS title FROM " .
            TABLE_ADMIN_STAT_YEAR . "
                      GROUP BY title
                      ORDER BY title ASC")
);

$total_ref_gant_info = array(
    'name' => 'total_ref',
    'width' => 400,
    'height' => 300,
    'image' => DIR_WS_GRAPHS . 'total_ref_gant.' . EXT,
    'title' => TABLE_HEADING_TOTAL_TOP,
    'info' => array(),
    'query' => xtc_db_query("SELECT sum(count) AS value, 
                       referer_url AS title FROM " .
            TABLE_ADMIN_STAT_YEAR . " 
                       GROUP BY title
                       ORDER BY value DESC LIMIT 10")
);

$tmp = array();
while ($element = xtc_db_fetch_array($month_gant_info['query'])) {
    $tmp[] = $element;
}
if (sizeof($tmp) < $day) {
    $d = 1;
    while ($d <= $day) {
        $array_element = xtc_find_title($tmp, $d);
        if ($array_element == false) {
            $month_gant_info['info'][] = array('title' => $d, 'value' => 0);
        } else {
            $month_gant_info['info'][] = $array_element;
        }
        $d++;
    }
} else {
    $month_gant_info['info'] = $tmp;
}
while ($element = xtc_db_fetch_array($year_gant_info['query'])) {
    $year_gant_info['info'][] = $element;
}
while ($element = xtc_db_fetch_array($total_gant_info['query'])) {
    $total_gant_info['info'][] = $element;
}
while ($element = xtc_db_fetch_array($month_ref_gant_info['query'])) {
    $month_ref_gant_info['info'][] = $element;
}
while ($element = xtc_db_fetch_array($year_ref_gant_info['query'])) {
    $year_ref_gant_info['info'][] = $element;
}
while ($element = xtc_db_fetch_array($total_ref_gant_info['query'])) {
    $total_ref_gant_info['info'][] = $element;
}

$gant_info = array(
    $month_gant_info,
    $year_gant_info,
    $total_gant_info,
    $month_ref_gant_info,
    $year_ref_gant_info,
    $total_ref_gant_info
);

for ($i = 0; $i < count($gant_info); $i++) {
    if (file_exists($gant_info[$i]['image'])) {
        @unlink($gant_info[$i]['image']);
    }
}

/* Create the gant images  */
for ($n = 0; $n < (sizeof($gant_info)); $n++) {
    $gant_image = $gant_info[$n];
    $wich_gant = $gant_image['name'];
    $stats_info = $gant_image['info'];
    $stats = array();
    $legend_array = array();
    if (sizeof($stats_info) > 0) {
        if ($wich_gant == 'month' || $wich_gant == 'year' || $wich_gant == 'total') {
            $dataType = '';
            $type = 'stackedbars';
            $legend = false;
            $shading = 5;
            while (list(, $element) = each($stats_info)) {
                $stats[] = array($element['title'], $element['value']);
            }
        } else {
            $dataType = 'text-data-single';
            $type = 'pie';
            $legend = true;
            $shading = 15;
            $i = 1;
            while (list(, $element) = each($stats_info)) {
                $stats[] = array($element['title'], $element['value'], '');
                $legend_array[] = $i;
                $i++;
            }
        }

        $graph = new PHPlot($gant_image['width'], $gant_image['height'], $gant_image['image']);

        $graph->SetPrintImage(0);
        $graph->SetFileFormat(EXT);
        $graph->SetIsInline(1);
        $graph->SetXTickLabelPos('none');
        $graph->SetXTickIncrement(1);
        $graph->SetDrawYGrid(1);
        $graph->SetPrecisionY(0);
        $graph->SetPlotBorderType('left');
        $graph->SetVertTickPosition('plotleft');
        $graph->SetBackgroundColor('white');
        $graph->SetTitleFontSize(4);
        $graph->SetShading($shading);
        $graph->SetPlotType($type);
        $graph->SetRGBArray('small');

        $graph->SetTitle($gant_image['title']);
        $graph->SetDataValues($stats);

        if (!$dataType == '') {
            $graph->SetDataType($dataType);
        }

        if ($legend == true) {
            $graph->SetLegend($legend_array);
        }

        $graph->DrawGraph();
        $graph->PrintImage();
    }
}
?>
<br>
<div id="tabslang">
	<ul>
		<li><a href="#module20"><?php echo HEADING_MONTH; ?></a></li>
		<li><a href="#module21"><?php echo HEADING_YEAR; ?></a></li>
		<li><a href="#module22"><?php echo HEADING_TOTAL; ?></a></li>
	</ul>

        <div id="module20">
            <h2 class="tab"><?php echo HEADING_MONTH; ?></h2>

            <table width="100%" border="0" cellpadding="0" cellspacing="4">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="2" class="dataTableHeadingContent" align="center"><?php echo $month_gant_info['title']; ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DAY; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            while (list(, $month_info) = each($month_gant_info['info'])) {
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $month_info['title']; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $month_info['value']; ?></td>
                                </tr>
                            <?php } //while  ?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($month_gant_info); ?></td>
                </tr>
                <tr>
                    <td width="50%" valign="top">  
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="3" class="dataTableHeadingContent" align="center"><?php echo $month_ref_gant_info['title']; ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_REFERER_NR; ?></td>
                                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_REFERER_ULR; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            $i = 1;
                            while (list(, $monthly_top_referer_info) = each($month_ref_gant_info['info'])) {
                                if ($monthly_top_referer_info['title'] == '') {
                                    $referer = NO_REFERER;
                                } else {
                                    $referer = '<a href="' . $monthly_top_referer_info['title'] . '" target="_blank">' . substr($monthly_top_referer_info['title'], 0, 70) . '</a>';
                                }                  
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $i . '.'; ?></td>
                                    <td class="dataTableContent"><?php echo $referer; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $monthly_top_referer_info['value']; ?></td>
                                </tr>
                                <?php $i++;
                            }
                            ?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($month_ref_gant_info); ?></td>
                </tr>
            </table>
        </div>
        <div id="module21">
		<h2 class="tab"><?php echo HEADING_YEAR; ?></h2>

            <table width="100%" border="0" cellpadding="0" cellspacing="4">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="2" class="dataTableHeadingContent" align="center"><?php echo $year_gant_info['title']; ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_MONTH_OF_YEAR; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            $year_info = reset($year_gant_info['info']);
                            while (list(, $year_info) = each($year_gant_info['info'])) {
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $year_info['title']; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $year_info['value']; ?></td>
                                </tr>
<?php } //while   ?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($year_gant_info); ?></td>
                </tr>
                <tr>
                    <td width="50%" valign="top">  
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="3" class="dataTableHeadingContent" align="center"><?php echo $year_ref_gant_info['title']; ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_REFERER_NR; ?></td>
                                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_REFERER_ULR; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            $i = 1;
                            while (list(, $yearly_top_referer_info) = each($year_ref_gant_info['info'])) {
                                if ($yearly_top_referer_info['title'] == '') {
                                    $referer = NO_REFERER;
                                } else {
                                    $referer = '<a href="' . $yearly_top_referer_info['title'] . '" target="_blank">' . substr($yearly_top_referer_info['title'], 0, 70) . '</a>';
                                } //->if 
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $i . '.'; ?></td>
                                    <td class="dataTableContent"><?php echo $referer; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $yearly_top_referer_info['value']; ?></td>
                                </tr>
                                <?php $i++;
                            } //while  
                            ?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($year_ref_gant_info); ?></td>
                </tr>
            </table>
        </div>
        <div id="module22">
			<h2 class="tab"><?php echo HEADING_TOTAL; ?></h2>
            <table width="100%" border="0" cellpadding="0" cellspacing="4">
                <tr>
                    <td width="50%" valign="top">
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="2" class="dataTableHeadingContent" align="center"><?php echo $total_gant_info['title'] ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TOTAL_YEAR; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            while (list(, $total_info) = each($total_gant_info['info'])) {
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $total_info['title']; ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $total_info['value']; ?></td>
                                </tr>
<?php } //while   ?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($total_gant_info); ?></td>
                </tr>
                <tr>
                    <td width="50%" valign="top">  
                        <table width="100%" cellpadding="2" cellspacing="0" border="0">
                            <tr class="dataTableHeadingRow">
                                <td colspan="3" class="dataTableHeadingContent" align="center"><?php echo $total_ref_gant_info['title']; ?></td>
                            </tr>
                            <tr class="dataTableHeadingRow">
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_REFERER_NR; ?></td>
                                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_REFERER_ULR; ?></td>
                                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_COUNT; ?></td>
                            </tr>
                            <?php
                            $i = 1;
                            while (list(, $total_top_referer_info) = each($total_ref_gant_info['info'])) {
                                if ($total_top_referer_info['title'] == '') {
                                    $referer = NO_REFERER;
                                } else {
                                    $referer = '<a href="' . $total_top_referer_info['title'] . '" target="_blank">' . substr($total_top_referer_info['title'], 0, 70) . '</a>';
                                } //->if  
                                ?>
                                <tr class="dataTableRow" onmouseover="this.className = 'dataTableRowOver'" onmouseout="this.className = 'dataTableRow'">
                                    <td class="dataTableContent" align="center"><?php echo $i . '.'; ?></td>
                                    <td class="dataTableContent"><?php echo $referer ?></td>
                                    <td class="dataTableContent" align="center"><?php echo $total_top_referer_info['value']; ?></td>
                                </tr>
    <?php $i++;
} //while  
?>
                        </table>
                    </td>
                    <td width="50%" style="border: 1px solid #C1C1C1;" align="center"><?php echo xtc_get_image_graph($total_ref_gant_info); ?></td>
                </tr>
            </table>
        </div>
</div>
    <br>