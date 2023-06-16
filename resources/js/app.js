import './bootstrap';

$(function () {
    const form = $('#form');

    $('.task').dblclick(function () {
        const id = $(this).data('id');
        $(this).addClass('hidden');
        $(`.task-show-${id}`).removeClass('hidden');
        $(`#task-icon-${id}`).addClass('hidden')
    });

    $('.task-cancel').click(function () {
        const data = $(this).parent();
        const id = data.attr('data-id');
        $(`.task-show-${id}`).addClass('hidden');
        const curId = $(`.task[data-id=${id}]`);
        const getId = curId.data('id');
        if (getId === parseInt(id)) {
            $('.task').removeClass('hidden')
        }
        $(`#task-icon-${id}`).removeClass('hidden')
    });

    $('.delete').click(function () {
        if (window.confirm("Are you sure?")) {
            const elem = $(this).attr('id');
            const split = elem.split("-");
            const id = split[2];
            form.attr('action', `/delete/${id}`);
            $('#method').val("DELETE")
            form.attr('method', 'post');
            form.submit();
        }
    })

    $('.update').click(function () {
        const id = $(this).parent().data('id');
        const text = $(`.task-text-${id}`)
        if (text.val() === '') {
            return text.focus();
        }

        const formData = new FormData(); // Create a new FormData object
        formData.append("name", text.val());
        form.attr('action', `/update/${id}`);
        $('#method').val("PUT")
        form.attr('method', 'post');

        formData.forEach((value, key) => {
            const input = $('<input>').attr('type', 'hidden').attr('name', key).val(value);
            form.append(input);
        });

        form.submit();
    });

    $('#add-task').click(function () {
        if ($('#task-form').hasClass('hidden')) {
            $('#task-form').removeClass('hidden')
            $(this).text('Close')
        } else {
            $(this).text('Add Task')
            $('#task-form').addClass('hidden')
        }
    });

    $('#add-new-task').click(function () {
        const taskName = $('#task-name')
        const projectName = $('#project-name');
        const priority = $('#task-priority');
        const existingProject = $('#existing-project');

        if (taskName.val() === '') {
            return taskName.focus()
        }
        if (priority.val() === '') {
            return priority.focus();
        }
        let project = existingProject.val();
        if(projectName.val() !== '') {
            project = projectName.val();
        }
        if(project === '') {
            return projectName.focus();
        }

        const formData = new FormData();
        formData.append("name", taskName.val());
        formData.append("priority", priority.val());
        formData.append("project", project);

        form.attr('action', `/store`);
        // $('#method').val("POST")
        form.attr('method', 'post');

        formData.forEach((value, key) => {
            const input = $('<input>').attr('type', 'hidden').attr('name', key).val(value);
            form.append(input);
        });

        form.submit();
    })

    $('#existing-project').change(function () {
        $('#project-name').attr('disabled', '').addClass('bg-gray-200')
        const id = $(this).val();
        window.location.href = '/?project_id=' + id // + encodeURIComponent(id);
    })

    $('#sortable').sortable({
        update: function (event, ui) {
            var order = $(this).sortable('toArray');
            $.ajax({
                url: "/api/tasks/order",
                method: "POST",
                data: {
                    order: order
                },
                success: (response) => {
                   const data = response.data;
                    data.forEach((value, index) => {
                        const [, , id] = value.split("-")
                        $(`.task-id-${id}`).text(index+1);
                    });
                },
                error: (err) => {
                    alert(err.message)
                }
            });
        }
    });
});
