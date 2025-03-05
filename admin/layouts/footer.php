</div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/scripts.js"></script>

        <!-- For Summer Note -->
        <script>
        $('#description').summernote({
            placeholder: 'Descrition for post',
            tabsize: 2,
            height: 120,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });

        //post ထဲက delete ကို နှိပ်ရင် အလုပ်လုပ်မယ့် JS Code
        $(document).ready(function() {
            $('tbody').on('click','.delete',function(){
                let id = $(this).data('id');
                // alert(id);
                $('#id').val(id);
                $('#deleteModal').modal('show');
            })
        })
    </script>
    </body>
</html>