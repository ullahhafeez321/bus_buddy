<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet"
            integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet">
        <link
            href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <link href="{{ asset('css/all.css') }}" rel="stylesheet">
        <title>@yield('title')</title>
    </head>

    <body>

        <header>
            <!-- Your header content -->
        </header>

        <div class="d-flex flex-direction-row">
            <div class="bg-primary" style="min-width: 280px; min-height: 100vh;">
                @include('components.sidebar')
            </div>
            <div class="p-4 flex-grow-1">
                <main>
                    @include('components.alert')
                    @yield('content')
                </main>
            </div>
        </div>

        <footer>
            <!-- Your footer content -->
        </footer>

        <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center">Are you sure you want to delete this item?</p>
                        <form id="deleteform" action="" method="post">
                            @csrf
                            <input id="deleteid" name="id" type="hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true"
            tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center" id="text">Do you confirm this action?</p>
                        <form id="confirmform" action="" method="post">
                            @csrf
                            <input id="confirmid" name="id" type="hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Confirm</button>
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
        <script src="{{ asset('js/datatable.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>
        @yield('script')
    </body>

</html>
