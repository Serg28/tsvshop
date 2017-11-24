var tfConfigAddons = {
    public_methods: false,
    btn_reset: true,
    //alternate_rows: true,
    loader: true,
    rows_counter: true,
    paging: true,
    status_bar: false,
    remember_grid_values: true,
    remember_page_number: true,
    hasStoredValues: true,
    //sorted: true,
    //grid_enable_cols_resizer: true,
    enable_default_theme: true,
    help_instructions: false,
    //sort: true,
    col_0: "null",
    col_1: "null",
    col_2: "null",
    col_3: "null",
    col_4: "null",
    col_5: "null",
    editable: false,
    col_resizer_all_cells: false,
    toolbar_target_id: 'addonstoolbar',
    results_per_page: ['Строк на страницу', [10, 15, 30, 50]],
    filters_row_visibility_at_start: false,
    grid_enable_default_filters: false,
    ezEditTable_config: {
        //default_selection: 'both'
    },
    grid: false
};


var tfAddons = setFilterGrid('addonstable', tfConfigAddons);

function uninstall(text) {
    if (confirm(text)) {
        this.click();
    } else {
        return false;
    }
}