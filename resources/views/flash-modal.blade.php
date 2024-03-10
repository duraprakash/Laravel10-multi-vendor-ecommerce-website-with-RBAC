<!-- flash-modal.blade.php -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Example usage in any blade file -->
                <!-- Success -->
                @if ($message = Session::get('success'))
                    <h2>
                        <svg fill="#009900" height="40px" width="50px" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 27.855 27.855" xml:space="preserve">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <g>
                                    <path
                                        d="M27.604,6.751L14.176,20.18c-0.338,0.336-0.885,0.336-1.223,0l-0.27-0.27l0,0l-0.293-0.293l-1.268-1.268l-0.018-0.027 L5.297,12.47c-0.336-0.336-0.336-0.885,0-1.221l1.83-1.828c0.338-0.339,0.883-0.339,1.221,0l5.223,5.262L24.551,3.7 c0.338-0.337,0.885-0.337,1.221,0l1.832,1.832C27.939,5.867,27.939,6.415,27.604,6.751z">
                                    </path>
                                    <path
                                        d="M21.795,22.613c0,0.973-0.793,1.766-1.768,1.766H3.535c-0.975,0-1.768-0.793-1.768-1.766V5.241 c0-0.973,0.793-1.766,1.768-1.766h16.492c0.975,0,1.768,0.793,1.768,1.766l0,0l1.256-1.162c0.203-1.43-1.242-2.369-3.024-2.369 H3.535C1.582,1.71,0,3.29,0,5.241v17.372c0,1.951,1.582,3.533,3.535,3.533h16.492c1.953,0,3.535-1.582,3.535-3.533V12.257 l-1.768,1.924L21.795,22.613L21.795,22.613z">
                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span id="messageContent"></span>
                    </h2>
                @endif

                <!-- Error -->
                @if ($message = Session::get('error'))
                    <p>Ooops!!!</p>
                    <h2>
                        <svg fill="#fbd618" height="40px" width="50px" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path
                                    d="M12,1A11,11,0,1,0,23,12,11.013,11.013,0,0,0,12,1Zm0,20a9,9,0,1,1,9-9A9.011,9.011,0,0,1,12,21Zm1-3H11V16h2Zm0-4H11V6h2Z">
                                </path>
                            </g>
                        </svg>
                        <span id="messageContent"></span>
                    </h2>
                @endif

                <!-- Info -->
                @if ($message = Session::get('info'))
                    <h2>
                        <svg fill="#0dcaf0" height="40px" width="50px" viewBox="0 0 16 16"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M7.37 6.7h1.25v5H7.37z"></path>
                                <circle cx="8" cy="4.85" r=".65"></circle>
                                <path
                                    d="M8 .5A7.77 7.77 0 0 0 0 8a7.77 7.77 0 0 0 8 7.5A7.77 7.77 0 0 0 16 8 7.77 7.77 0 0 0 8 .5zm0 13.75A6.52 6.52 0 0 1 1.25 8 6.52 6.52 0 0 1 8 1.75 6.52 6.52 0 0 1 14.75 8 6.52 6.52 0 0 1 8 14.25z">
                                </path>
                            </g>
                        </svg>
                        <span id="messageContent"></span>
                    </h2>
                @endif

                <!-- Warning -->
                @if ($message = Session::get('warning'))
                    <h2>
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"
                            fill="#000000" height="40px" width="50px">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <polygon style="fill:#FFA418;" points="0,477.703 256,477.703 289.391,256 256,34.297 ">
                                </polygon>
                                <polygon style="fill:#FF8A1E;" points="256,34.297 256,477.703 512,477.703 "></polygon>
                                <g>
                                    <circle style="fill:#324860;" cx="256" cy="405.359" r="16.696"></circle>
                                    <rect x="239.304" y="177.185" style="fill:#324860;" width="33.391" height="178.087">
                                    </rect>
                                </g>
                            </g>
                        </svg>
                        <span id="messageContent"></span>
                    </h2>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Example usage in any blade file -->
@if ($message = Session::get('success'))
    <script>
        $(document).ready(function() {
            $('#messageContent').text('{{ $message }}');
            $('#messageModal').modal('show');
        });
    </script>
@endif --}}

<!-- Example usage in any blade file -->
@if (Session::has('success') ||
        Session::has('error') ||
        Session::has('warning') ||
        Session::has('info') ||
        $errors->any())
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                $('#messageContent').text('{{ Session::get('success') }}');
            @elseif (Session::has('error'))
                $('#messageContent').text('{{ Session::get('error') }}');
            @elseif (Session::has('warning'))
                $('#messageContent').text('{{ Session::get('warning') }}');
            @elseif (Session::has('info'))
                $('#messageContent').text('{{ Session::get('info') }}');
            @elseif ($errors->any())
                $('#messageContent').text('Please check the form below for errors');
            @endif
            $('#messageModal').modal('show');
        });
    </script>
@endif
