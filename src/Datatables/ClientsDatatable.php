<?php

namespace App\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Style;

/**
 * Class ClientsDatatable
 *
 * @package App\Datatables
 */
class ClientsDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function ($row) {
            //$row['test'] = 'Post from ' . $row['createdBy']['username'];
            return $row;
        };

        return $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->ajax->set(array(
            // send some extra example data
            'data' => array('data1' => 1, 'data2' => 2),
            // cache for 10 pages
            'pipeline' => 25,
            'url' => $this->router->generate('client_list')
            // 'type' => 'POST',
            // 'url' => $this->router->generate('cms_links_results')
            // https://github.com/stwe/DatatablesBundle/issues/742
        ));

        $this->options->set(array(
            'classes' => Style::BOOTSTRAP_4_STYLE,
            //'stripe_classes' => [ 'strip1', 'strip2', 'strip3' ],
            'individual_filtering' => true,
            'individual_filtering_position' => 'head', //'both', 'foot' or 'head'
            'order' => array(array(1, 'asc')),
            'order_cells_top' => true,
            'global_search_type' => 'gt',
            'search_in_non_visible_columns' => true,
            'length_menu' => ['25', '50', '100', '500'],
            'page_length' => 25,
            'dom' => 'lrtip',
        ));

        $this->extensions->set(array(
            'responsive' => true,
        ));
        // $this->extensions->set([
        //     'buttons' => [
        //        'create_buttons' => [
        //            [
        //               'text' => 'Reload',
        //               'action' => [
        //                  'template' => 'js/reload.js.twig',
        //               ],
        //            ],
        //         ],
        //     ],
        //  ]);

        // $this->callbacks->set([
        //     'state_loaded' => [
        //         'template' => 'js/DataTable/filter_callback.js.twig',
        //         'vars' => [],
        //     ],
        //     'draw_callback' => [
        //         'template' => 'js/DataTable/draw_callback.js.twig',
        //         'vars' => [],
        //     ],

        // ]);

        $this->features->set(array(
            'auto_width' => false,
            'processing' => true,
        ));

        $this->columnBuilder
            ->add('nom', Column::class, array(
                'title' => 'Last Name',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('prenom', Column::class, array(
                'title' => 'First Name',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('genre', Column::class, array(
                'title' => 'Genre',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('email', Column::class, array(
                'title' => 'E-Mail',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add(null, ActionColumn::class, array(
                'title' => 'Actions',
                'start_html' => '<div class="start_actions">',
                'end_html' => '</div>',
                'actions' => array(
                    array(
                        'route' => 'client_mensuration',
                        'route_parameters' => array(
                            'client' => 'id',
                        ),
                        'icon' => 'fa fa-ruler',
                        'label' => '',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Mensuration',
                            'class' => 'btn btn-xs',
                            'role' => 'button',
                        ),
                        'start_html' => '<div class="start_show_action">',
                        'end_html' => '</div>',
                    ),
                    array(
                        'route' => 'client_edit',
                        'route_parameters' => array(
                            'client' => 'id',
                        ),
                        'icon' => 'fa fa-pen-to-square',
                        'label' => '',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Edition',
                            'class' => 'btn btn-xs',
                            'role' => 'button',
                        ),
                        'start_html' => '<div class="start_show_action">',
                        'end_html' => '</div>',
                    ),
                )
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'App\Entity\Clients';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'client_datatable';
    }
}
