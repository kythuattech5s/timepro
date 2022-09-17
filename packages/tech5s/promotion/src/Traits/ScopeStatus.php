<?php
namespace Tech5s\Promotion\Traits;

use DateTime;
trait ScopeStatus
{
    public function getStatus($skeleton = true)
    {
        $time_start = new DateTime($this->start_at);
        $time_end = new DateTime($this->expired_at);
        $now = new DateTime();
        if ($now <= $time_end && $now >= $time_start) {
            $class = "success";
            $content = 'Đang diễn ra';
        } elseif ($now < $time_start && $now < $time_end) {
            $class = "warning";
            $content = 'Sắp diễn ra';
        } else {
            $class = "danger";
            $content = "Đã kết thúc";
        }

        $skeleton = $skeleton ? 'skeleton-loading' : '';
        echo "<span class='promotion-status promotion-status-$class' style='display: -webkit-inline-box;' $skeleton>$content</span>";
    }
}
