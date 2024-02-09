/**
 * Initially based on Omeka S omeka2importer.js and resource-core.js.
 */
(function ($) {
    $(document).ready(function () {

        let defaultSidebarHtml = null;
        let sidebarActive = false;

        function initEvent() {
            $('.archival_resource').on('click', function (e) {
                e.preventDefault();
                const element = $(this);
                const parentElement = element.parent();
                if (!parentElement.closest('div').hasClass('archival_tree_head')) {
                    const id = parentElement.data('resource-id');
                    const resource_type = parentElement.data('resource-type');

                    $.ajax({
                        url: `item-set-party/relations/${resource_type}/${id}`,
                    }).done(function (data) {
                        const $data = $(data);

                        $data.find('li').each(function () {
                            const liId = $(this).find('a').attr('id');
                            if (!parentElement.find(`#${liId}`).length) {
                                const list = $("<ul></ul>");
                                list.append(this);
                                parentElement.append(list);
                            }
                        });
                        initEvent();
                    });
                }
                element.addClass('parent_active');
            });

            $('.resource_details_view').on('click', function (e) {
                e.preventDefault();
                const sidebar = $("#resource-details");
                const sidebarContent = sidebar.find('#sidebar-content');

                if (!sidebar.hasClass('active')) {
                    defaultSidebarHtml = sidebarContent.html();
                }
                const parentElement = $(this).parent();
                const id = parentElement.data('resource-id');
                const resource_type = parentElement.data('resource-type');

                $.ajax({
                    url: `item-set-party/resource-details/${resource_type}/${id}`,
                }).done(function (data) {
                    if (sidebarActive) {
                        sidebarContent.html(data);
                    } else {
                        sidebar.addClass('active');
                        sidebarContent.html(data);
                        sidebarActive = true;
                    }
                });

                $('.sidebar-close').on('click', function () {
                    const sidebar = $("#resource-details");
                    sidebar.removeClass('active');
                    sidebarActive = false;
                });
            });
        }
        initEvent();
    });
})(jQuery);
