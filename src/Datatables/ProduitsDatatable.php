<?php

namespace App\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Style;

/**
 * Class ProduitsDatatable
 *
 * @package App\Datatables
 */
class ProduitsDatatable extends AbstractDatatable
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
            'url' => $this->router->generate('produits_list')
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
            ->add('ref', Column::class, array(
                'title' => 'ref',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('designation', Column::class, array(
                'title' => 'designation',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('types', Column::class, array(
                'title' => 'Genre',
                'searchable' => true,
                'orderable' => true,
            ))
            ->add('taille', Column::class, array(
                'title' => 'taille',
                'searchable' => true,
                'orderable' => true,
            ))
            // ->add(null, ActionColumn::class, array(
            //     'title' => 'Actions',
            //     'start_html' => '<div class="start_actions">',
            //     'end_html' => '</div>',
            //     'actions' => array(
            //         array(
            //             'route' => 'client_mensuration',
            //             'route_parameters' => array(
            //                 'client' => 'id',
            //             ),
            //             'icon' => 'glyphicon glyphicon-eye-open',
            //             'label' => 'M',
            //             'attributes' => array(
            //                 'rel' => 'tooltip',
            //                 'title' => 'Mensuration',
            //                 'class' => 'btn btn-primary btn-xs',
            //                 'role' => 'button',
            //             ),
            //             'start_html' => '<div class="start_show_action">',
            //             'end_html' => '</div>',
            //         ),
            //     )
            // ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'App\Entity\Produits';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'Produits_datatable';
    }
}
