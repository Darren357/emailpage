/* 
 *   Feb 7, 2015   11:18:58 PM 
 *   @copyright (c) 2015,  Alex Shulzhenko,  contact@alexshulzhenko.ru
 *   @license GPL 3.0, http://opensource.org/licenses/GPL-3.0
 *
 */

/**
 * Sends request to check files for updates
 * @return  - ignored
 */
(function () {
    /**
     * @constant  - Change this value if you are not satisfied with default
     *     Setting smaller number will cause requests to be send more often but
     *     in the same time page will be realoded faster
     * @type {Number} how often to check for changes - in seconds
     */ 
    var UPDATE_INTERVAL = 1000;

    var path = location.origin + '/smart_reloader.php',
            last_value = 0;

    var timer = setInterval(function () {
        jQuery.post(path, {}, function (result) {

            if (!jQuery.isNumeric(result)) {
                clearInterval(timer);
                alert('Error happened, check logs');
                console.log(result);
            }

            if (result != last_value && last_value != 0) {
                location.reload();
            } else {
                last_value = result;
            }

        }).fail(function (xhr, textStatus, errorThrown) {
            clearInterval(timer);
            location.reload();
//            alert(path + " fail, check path to the php script");
            console.log(xhr.responseText);
            console.log(textStatus);
            console.log(errorThrown);
        });
    }, UPDATE_INTERVAL);
})();