<?php

namespace App\Datatables;

use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Style;

/**
 * Class UsersDatatable
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
            // ->add(null, ActionColumn::class, array(
            //     'title' => 'Actions',
            //     'start_html' => '<div class="start_actions">',
            //     'end_html' => '</div>',
            //     'actions' => array(
            //         array(
            //             'route' => 'rightsmanagements_user_edit',
            //             'button' => true,
            //             'button_value' => 'id',
            //             'attributes' => function ($row) {
            //                 return  array(
            //                     'data-type' => 'popup',
            //                     'data-title' => 'User Edit',
            //                     'title' => 'User Edit',
            //                     'data-href' => 'RightsManagements/User/' . $row['id'] . '/Edit',
            //                     'class' => 'buttonStyle fa fa-pencil-alt',
            //                 );
            //             },
            //         ),
            //         array(
            //             'route' => 'rightsmanagements_user_delete',
            //             'button' => true,
            //             'button_value' => 'id',
            //             'attributes' => function ($row) {
            //                 return  array(
            //                     'data-type' => 'popup',
            //                     'data-title' => 'User Delete',
            //                     'title' => 'User Delete',
            //                     'data-href' => 'RightsManagements/User/' . $row['id'] . '/Delete',
            //                     'class' => 'buttonStyle fa fa-times',
            //                 );
            //             },
            //         )
            //     )
            // ))
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
