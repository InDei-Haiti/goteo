<?php 
use Goteo\Library\Check;

$project=$this->project;

$percentage= floor(($this->project->amount/$this->project->mincost)*100);
$status=$project->status;

$date_created = $project->created;
$date_updated = $project->updated;
$date_success = $project->success;
$date_published = $project->published;

$date_closed  = $project->closed;

$days       = $project->days;
$days_round1 = $project->days_round1;
$days_total = $project->days_total;
$round      = $project->round;



if ($status == 3)
{ // en campaña
    if ($days > 2) {
        $days_left = number_format($days);
        $days_left2 = $this->text('regular-days');
    } else {

        $part = strtotime($date_published);
        if ($round == 1) {
            $plus = $days_round1;
        }
        elseif ($round == 2) {

        $plus = $days_total;
        $final_day = date('Y-m-d', mktime(0, 0, 0, date('m', $part), date('d', $part)+$plus, date('Y', $part)));
        $days_left = Check::time_togo($final_day, 1);
        $days_left2 = '';
        }
    }
$days_left.=' '.$this->text('regular-days');
$text=strtolower($this->text('project-view-metter-days'));

}

elseif (!empty($status)) {
    switch ($status) {
        case 1: // en edicion
          $text = 'project-view-metter-day_created';
            $date = $date_created;

           case 2: // pendiente de valoración
            $text = 'project-view-metter-day_updated';
            $date = $date_updated;
            break;

        case 4: // financiado
        case 5: // retorno cumplido
            $text = 'project-view-metter-day_success';
            $date = $date_success;
            break;

        case 6: // archivado
            $text = 'project-view-metter-day_closed';
           $date = $date_closed;
            break;
    }
    $text=strtolower($this->text($text));
    $days_left=date('d/m/Y', strtotime($date));
}
?>
<div class="project-widget">
    <a href="/project/<?= $this->project->id ?>">
        <img class="img-responsive img-project" src="<?= $this->project->image->getLink(600, 330, true); ?>">
    </a>
    <div class="content">    
        <div class="title"><a href="/project/<?= $this->project->id ?>"><?= $this->text_truncate($this->project->name, 80); ?></a></div>
        <div class="author">
            <a href="/user/profile/<?= $this->project->user->id?>" style="color:#20B3B2 !important" target="_blank"><?= $this->text('regular-by').' '.$this->project->user->name ?></a>
        </div>
        <div class="description">            
            <?= $this->text_truncate($this->project->description, 150) ?>
        </div>
        <ul class="amounts list-unstyled text-center">
            <li class="col-xs-4">
                <div class="amount"><?= amount_format($this->project->invested) ?></div>
                <div class="data-label"><?= $this->text('horizontal-project-reached') ?></div>
            </li>
            <li class="col-xs-4">
                <div class="amount"><?= $percentage.' %' ?></div>
                <div class="data-label"><?= $this->text('horizontal-project-percent') ?></div>
            </li>
            <li class="col-xs-4">
                <div class="amount"><?= $days_left ?></div>
                <div class="data-label"><?= $text ?></div>
            </li>
        </ul>
    </div>
</div>

