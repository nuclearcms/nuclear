<?php

namespace Reactor\Http\Presenters\Pagination;


use Illuminate\Pagination\SimpleBootstrapThreePresenter;

class PaginationPresenter extends SimpleBootstrapThreePresenter{

    /**
     * Convert the URL window into Bootstrap HTML.
     *
     * @return string
     */
    public function render()
    {
        return sprintf(
            '<ul class="pager">%s%s%s</ul>',
            $this->getPreviousButton('<i class="icon-left-open-big"></i>'),
            $this->getPageIndicator(),
            $this->getNextButton('<i class="icon-right-open-big"></i>')
        );
    }

    /**
     * Renders the page indicatior
     *
     * @return string
     */
    protected function getPageIndicator()
    {
        return sprintf(
            '<li class="pager-indicator"><span>%s %s/%s</span></li>',
            uppercase(trans('general.page')),
            $this->currentPage(),
            $this->lastPage()
        );
    }

}