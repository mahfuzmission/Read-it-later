
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pocket</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/offcanvas/">
    <link href="{{asset('asset/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/offcanvas.css')}}" rel="stylesheet">

    <style>
        a {
            color: #0060B6;
            text-decoration: none !important;
        }

        a:hover {
            color:#00A0C6;
            text-decoration: none !important;
            cursor:pointer;
        }

        .pagination {
            display: inline-block;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 2px 8px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .active{
            color: green;
        }

    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="javascript:void(0)">Pocket - Read It Later</a>
    <input class="form-control form-control-dark w-100" type="text" id="search_value" placeholder="Search" aria-label="Search">
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link search_content" href="#">Search</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Pockets</span>
                    <a class="d-flex align-items-center text-muted" href="javascript:void(0)">
                        <button id="pocket_create" type="button" style="line-height:1.0;" class="btn btn-sm btn-outline-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                        </button>
                    </a>
                </h6>
                <ul id="pocket_data" class="nav flex-column mb-2"></ul>
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="my-3 p-3 bg-white rounded shadow-sm">
                <h6 class="border-bottom border-gray pb-2 mb-0">Contents</h6>
                <div id="content_data"></div>

                <div class="mt-3 media text-muted pt-4">
                    <div class="input-group mb-3 col-5">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">Add Tags</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Type Tags" id="hashtags" value="">
                    </div>
                    <div class="input-group mb-3 col-5">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">Content or URL</span>
                        </div>
                        <input type="text" class="form-control" placeholder="Type Content or URL" id="pocket_content" value="">
                    </div>
                    <input class="col-3" type="hidden" id="active_pocket_id" value="">
                    <a id="new_content" class="btn btn-outline-success" href="javascript:void(0)">
                        Add Content
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
{{--<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>--}}
<script src="{{asset('asset/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('asset/popper.min.js')}}"></script>
<script src="{{asset('asset/bootstrap.min.js')}}"></script>
<script src="{{asset('asset/holder.min.js')}}"></script>
<script src="{{asset('asset/offcanvas.js')}}"></script>

<script>
    $(document).ready(function() {

        function loadPockets() {
            $('#pocket_data').empty();

            let url = "{{route('get-pockets')}}";
            $.get(url, function(response, status, xhr){
                if(xhr.status === 200) {
                    let li = "";
                    for(let i=0; i<response.data.length; i++ ) {
                        let url = '{{ route("content-search", ['pocket_id' => "value"]) }}';
                        url = url.replace('value', response.data[i].id);
                        li += '<li class="nav-item">' +
                                 '<a id="'+ response.data[i].id +'_contents" class="nav-link contents" href="javascript:void(0)" data-href="'+ url +'" data-id="'+ response.data[i].id +'" >' +
                                     '<span data-feather="file-text"></span>' +
                                      response.data[i].pocket_name +
                                 '</a>' +
                             '</li>';
                    }

                    if(response.data.length > 0)
                    {
                        li += '<li>' +
                            '<div class="pagination_section">' +
                            '<a style="float: left; '+ ((response.prev_page_url == null) ? 'pointer-events: none;' : '') +'" href="'+ response.prev_page_url +'"><< Previous</a>' +
                            '<a style="float: right; '+ ((response.next_page_url == null) ? "pointer-events: none;" : "") +'" href="'+ response.next_page_url +'">Next >></a>' +
                            '</div>' +
                            "</li>";
                    }


                    $('#pocket_data').append(li);
                }
            });
        }

        $("#pocket_create").click(function(){
            $.post("{{route('create-pocket')}}",
                function(data){
                    alert(data.data);
                });

            loadPockets();
        });

        loadPockets();

        function loadContents(url){
            $('#content_data').empty();

            $.get(url, function(response, status, xhr){
                let contents = "";
                if(xhr.status === 200) {
                    for(let i=0; i<response.data.length; i++ )
                    {
                        let tags = [];
                        let src = 'src="{{asset('image/no-image.png')}}"';
                        if(response.data[i].tags != null && response.data[i].tags.length > 0)
                        {
                            tags = response.data[i].tags.map(item => '#'+item.tag_name);
                        }
                        if(response.data[i].image != "" && response.data[i].image != null)
                        {
                            src = 'src="'+response.data[i].image +'"';
                        }
                        let title = (response.data[i].title != null) ? response.data[i].title : "";
                        let excerpt = (response.data[i].excerpt != null) ? response.data[i].excerpt : "";

                        contents += '<div class="media text-muted pt-3">'+
                            '<img ' + src +' alt="" width="100" height="150" class="mr-2 rounded">'+
                            '<p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">'+
                            '<strong class="d-block text-gray-dark">'+ tags.join(' ') +'</strong>'+
                                response.data[i].content +
                            '<strong class="d-block text-gray-dark">Title : '+ title +'</strong>'+
                            '<span>Excerpt : ' +  excerpt + '<span>'+
                            '</p>'+
                            '<button style="margin-right: 50px;" type="button" data-id="'+ response.data[i].id +'" class="btn btn-outline-danger content_delete">delete</button>'+
                            '</div>';
                    }

                    if(response.data.length > 0)
                    {
                        contents += '<div class="media text-muted pt-3">' +
                            '<div class="pagination_section col-5">' +
                            '<a style="float: left; '+ ((response.prev_page_url == null) ? 'pointer-events: none;' : '') +'" href="'+ response.prev_page_url +'"><< Previous</a>' +
                            '<a style="float: right; '+ ((response.next_page_url == null) ? "pointer-events: none;" : "") +'" href="'+ response.next_page_url +'">Next >></a>' +
                            '</div>' +
                            "</div>";
                    }


                    $('#content_data').append(contents);

                }
            });
        }

        $(document).on("click", "a.contents" , function() {
            let url = $(this).data('href');
            $('a.contents').removeClass('active');
            $(this).addClass('active');
            $('#active_pocket_id').val($(this).data('id'));

            loadContents(url);
        });

        $(document).on("click", "a#new_content" , function() {
            let pocket_id = $('#active_pocket_id').val();
            let pocket_content = $('#pocket_content').val();
            let hashtags = $('#hashtags').val();

            if(pocket_id != "" && pocket_content != "") {
                $.post("{{route('content-create')}}",
                    {
                        "pocket_id" : pocket_id,
                        "pocket_content" : pocket_content,
                        "hashtags" : hashtags,
                    },
                    function(data,success, xhr) {

                        if (xhr.status === 422) {
                            alert("Validation Error. Pls try again");
                        } else
                        {
                            alert(data.data);
                        }

                        if(xhr.status === 201)
                        {
                            let new_pocket_id = $('#active_pocket_id').val();
                            let new_url = '{{ route("content-search", ['pocket_id' => "value"]) }}';
                            new_url = new_url.replace('value', new_pocket_id);
                            loadContents(new_url);
                        }
                    });
            }
            else {
                alert("pocket not selected or content not found");
            }
        });

        $(document).on("click", "button.content_delete" , function() {
            let content_id = $(this).data('id');
            if (confirm('Are you sure ?')) {
                let url = "{{route('content-delete', "value")}}";
                url = url.replace('value', content_id);
                $.get(url, function(response,status, xhr){
                    alert(response.data)
                });

                let new_pocket_id = $('#active_pocket_id').val();
                let new_url = '{{ route("content-search", ['pocket_id' => "value"]) }}';
                new_url = new_url.replace('value', new_pocket_id);
                loadContents(new_url);
            }
        });

        $(document).on("click", "a.search_content" , function() {
            let search = $('#search_value').val();

            if(search != "")
            {
                let url = "{{route('content-search', [ "search" => "value"])}}";
                url = url.replace('value', encodeURIComponent(search));
                console.log(url);
                loadContents(url);
            }
            else{
                alert('No hashtag or keyword found.')
            }
        });

    });
</script>
</body>
</html>
