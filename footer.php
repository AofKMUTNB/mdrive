<footer>
      
        <div class="footer-mid ptb-50">
            <div class="container">
                <div class="row">
                    
                    <div class="col-lg-12 col-12 text-center">
                        <div class="single-footer mrg-sm">
                            <div class="footer-title mb-20">
                                <h3>บริษัท เอ็มไดร์ฟฮอนด้า ธนบุรี (M Drive)</h3>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </footer>
    <!-- footer-area-end -->
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 col-sm-5 col-xs-12">
                            <div class="modal-tab">
                                <div class="product-details-large tab-content">
                                    <div class="tab-pane active" id="image-1">
                                        <img src="img/product/quickview-l4.jpg" alt="" />
                                    </div>
                                    <div class="tab-pane" id="image-2">
                                        <img src="img/product/quickview-l2.jpg" alt="" />
                                    </div>
                                    <div class="tab-pane" id="image-3">
                                        <img src="img/product/quickview-l3.jpg" alt="" />
                                    </div>
                                    <div class="tab-pane" id="image-4">
                                        <img src="img/product/quickview-l5.jpg" alt="" />
                                    </div>
                                </div>
                                <div class="product-details-small quickview-active owl-carousel">
                                    <a class="active" href="#image-1"><img src="img/product/quickview-s4.jpg" alt="" /></a>
                                    <a href="#image-2"><img src="img/product/quickview-s2.jpg" alt="" /></a>
                                    <a href="#image-3"><img src="img/product/quickview-s3.jpg" alt="" /></a>
                                    <a href="#image-4"><img src="img/product/quickview-s5.jpg" alt="" /></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7 col-xs-12">
                            <div class="modal-pro-content">
                                <h3>Chaz Kangeroo Hoodie3</h3>
                                <div class="price">
                                    <span>$70.00</span>
                                </div>
                                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet.</p>
                                <div class="quick-view-select">
                                    <div class="select-option-part">
                                        <label>Size*</label>
                                        <select class="select">
                                            <option value="">S</option>
                                            <option value="">M</option>
                                            <option value="">L</option>
                                        </select>
                                    </div>
                                    <div class="quickview-color-wrap">
                                        <label>Color*</label>
                                        <div class="quickview-color">
                                            <ul>
                                                <li class="blue">b</li>
                                                <li class="red">r</li>
                                                <li class="pink">p</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <form action="#">
                                    <input type="number" value="1" />
                                    <button>Add to cart</button>
                                </form>
                                <span><i class="fa fa-check"></i> In stock</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->


    <!-- all js here -->
    <!-- jquery latest version -->
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <!-- popper js -->
    <script src="js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- owl.carousel js -->
    <script src="js/owl.carousel.min.js"></script>
    <!-- meanmenu js -->
    <script src="js/jquery.meanmenu.js"></script>
    <!-- wow js -->
    <script src="js/wow.min.js"></script>
    <!-- jquery.parallax-1.1.3.js -->
    <script src="js/jquery.parallax-1.1.3.js"></script>
    <!-- jquery.countdown.min.js -->
    <script src="js/jquery.countdown.min.js"></script>
    <!-- jquery.flexslider.js -->
    <script src="js/jquery.flexslider.js"></script>
    <!-- chosen.jquery.min.js -->
    <script src="js/chosen.jquery.min.js"></script>
    <!-- jquery.counterup.min.js -->
    <script src="js/jquery.counterup.min.js"></script>
    <!-- waypoints.min.js -->
    <script src="js/waypoints.min.js"></script>
    <!-- plugins js -->
    <script src="js/plugins.js"></script>
    <!-- main js -->
    <script src="js/main.js"></script>
</body>

<link href="datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/plug-ins/1.10.21/features/searchHighlight/dataTables.searchHighlight.css" rel="stylesheet">

<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.bootstrap4.min.js"></script>
<script src="datatables/datatables-demo.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.21/features/searchHighlight/dataTables.searchHighlight.min.js"></script>
<script src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>

<script>
    $(document).ready(function() {
    // $('#dataTable').DataTable();

        

    readtime();
} );

jQuery.extend({
    highlight: function (node, re, nodeName, className) {
        if (node.nodeType === 3) {
            var match = node.data.match(re);
            if (match) {
                var highlight = document.createElement(nodeName || 'span');
                highlight.className = className || 'highlight';
                var wordNode = node.splitText(match.index);
                wordNode.splitText(match[0].length);
                var wordClone = wordNode.cloneNode(true);
                highlight.appendChild(wordClone);
                wordNode.parentNode.replaceChild(highlight, wordNode);
                return 1; //skip added node in parent
            }
        } else if ((node.nodeType === 1 && node.childNodes) && // only element nodes that have children
                !/(script|style)/i.test(node.tagName) && // ignore script and style nodes
                !(node.tagName === nodeName.toUpperCase() && node.className === className)) { // skip if already highlighted
            for (var i = 0; i < node.childNodes.length; i++) {
                i += jQuery.highlight(node.childNodes[i], re, nodeName, className);
            }
        }
        return 0;
    }
});

jQuery.fn.unhighlight = function (options) {
    var settings = { className: 'highlight', element: 'span' };
    jQuery.extend(settings, options);

    return this.find(settings.element + "." + settings.className).each(function () {
        var parent = this.parentNode;
        parent.replaceChild(this.firstChild, this);
        parent.normalize();
    }).end();
};

jQuery.fn.highlight = function (words, options) {
    var settings = { className: 'highlight', element: 'span', caseSensitive: false, wordsOnly: false };
    jQuery.extend(settings, options);
    
    if (words.constructor === String) {
        words = [words];
    }
    words = jQuery.grep(words, function(word, i){
      return word != '';
    });
    words = jQuery.map(words, function(word, i) {
      return word.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
    });
    if (words.length == 0) { return this; };

    var flag = settings.caseSensitive ? "" : "i";
    var pattern = "(" + words.join("|") + ")";
    if (settings.wordsOnly) {
        pattern = "\\b" + pattern + "\\b";
    }
    var re = new RegExp(pattern, flag);
    
    return this.each(function () {
        jQuery.highlight(this, re, settings.element, settings.className);
    });
};




function readtime(){
    setTimeout(function() { readtime(); }, 3000);
    $.ajax({
        url: "sql.php",
        type: "POST",
        data: { 
            act: "check_my_order"
        },
        success: function(data) {
            var obj=JSON.parse(data);
            if(obj.num_data>0)
            {
                $(".noti1").html(obj.num_data);
                $(".noti1").addClass("show");
                $(".noti1").removeClass("hide");


            }else{
                $(".noti1").html("");
                $(".noti1").removeClass("show");
                $(".noti1").addClass("hide");


            }

        }
    });
}

function logout() {
    $.ajax({
        url: "sql.php",
        type: "POST",
        data: {
            act: "logout"
        },
        success: function() {
            window.location = "login.php";

        }
    });

}



function newApi(format, filnames) {
    return ExcellentExport.convert({
            anchor: 'anchorNewApi-' + format,
            filename: filnames ,
            format: format
        }, [{
            name: 'Sheet1',
            from: {
                table: 'datatable1'
            }
        }]);

}


function read_noti(id){
    $.ajax({
        url: "sql.php",
        type: "POST",
        data: {
            act: "read_noti",ids:id
        },
        success: function() {
            location.reload();

        }
    });
}
    </script>
</html>