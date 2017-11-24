var tfConfig = {
    public_methods: false,
    //alternate_rows: true,
    loader: true,
    rows_counter: true,
    paging: true,
    status_bar: false,
    remember_grid_values: true,
    remember_page_number: true,
    hasStoredValues: true,
    //col_width:['70px', '280px', '220px', '110px', '110px'],
//			col_date_type: [null, null, null, 'ymd', null, null, null],
    col_date_type: [null, null, null, null, 'ymd', null, null, null],

    //sort_config: { sort_types: ['number','string','string','ymd','number'] },
    //grid_layout: true, grid_width: '840px', grid_height: '300px',
    sorted: true,
    grid_enable_cols_resizer: true,
    enable_default_theme: true,
    help_instructions: false,
    //help_instructions_btn_text: '?',


    extensions: {
        name: ['FiltersRowVisibility', 'ColsVisibility'],
        src: ['../assets/snippets/tsvshop/admin/libs/datagrid/TFExt_FiltersRowVisibility/TFExt_FiltersRowVisibility.js', '../assets/snippets/tsvshop/admin/libs/datagrid/TFExt_ColsVisibility/TFExt_ColsVisibility.js'],
        description: ['Expand/Collapse filters row', ''],
        initialize: [function (o) {
                o.SetFiltersRowVisibility();
            }, function (o) {
                o.SetColsVisibility('ColsVisibility');
            }]
    },

    col_0: "null",
    col_5: "null",
    col_7: "null",
    display_all_text: "Показать все",

    results_per_page: ['', [10, 15, 30, 50]],
    btn_showHide_cols_text: 'Столбцы',
    btn_reset: true,
    sort: true,
    filters_row_visibility_at_start: false,
    selectable: false,
    editable: false,
    col_resizer_all_cells: true,
    toolbar_target_id: 'saletoolbar',

    ezEditTable_config: {
        default_selection: 'both'
    }
};


var tf = setFilterGrid('saletable', tfConfig);
