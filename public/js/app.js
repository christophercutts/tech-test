/**
 * Created by Clutz on 16/01/2016.
 */
/** Add **/
$(function() {
    $(".add").click(function() {
        var firstname = $(this).closest('tr').find('.firstname');
        var surname = $(this).closest('tr').find('.surname');
        $.ajax({
            url: "/add",
            method: "post",
            data: {
                firstname: firstname.val(),
                surname: surname.val()
            },
            success: function (data) {
                $("tbody").append('<tr class="test">' +
                    '<td><input type="text" name="people[][firstname]" class="firstname" value="' + firstname.val() + '" /></td>' +
                    '<td><input type="text" name="people[][surname]" class="surname" value="' + surname.val() + '" /></td>' +
                    '<td><button class="update">Update</button><button class="delete">Delete</button></td>' +
                    '</tr>');
                firstname.val('');
                surname.val('');
            }
        });
    });
    $(".update").click(function() {
        var id = $(this).closest('tr').find('.id');
        var firstname = $(this).closest('tr').find('.firstname');
        var surname = $(this).closest('tr').find('.surname');
        $.ajax({
            url: "/update",
            method: "post",
            data: {
                id: id.val(),
                firstname: firstname.val(),
                surname: surname.val()
            },
            success: function (data) {
                alert('Successfully updated: ' + firstname.val() + ' ' + surname.val());
            }
        });
    });

    $(".delete").click(function() {
        var row = $(this).closest('tr');
        var id = $(this).closest('tr').find('.id');
        $.ajax({
            url: "/delete",
            method: "post",
            data: {
                id: id.val()
            },
            success: function (data) {
               row.empty();
            }
        });
    });
});