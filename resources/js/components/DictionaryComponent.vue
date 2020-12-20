<template>
    <div>
        <a href="#" class="floatingBtn" data-toggle="modal" data-target="#dictionaryModal">
            <br>
            <i class="MyFloatingBtn icon-search"></i>
        </a>
        
        
        <!-- Modal -->
        <div class="modal fade text-xs-left" id="dictionaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel2"><i class="icon-search"></i> Search word on dictionary</h4>
                </div>
                <div class="modal-body">
                    <section>
                        <form class="searchForm">
                            <div class="input-group">
                                <input type="search" id="searchBox" name="searchBox" class="form-control border-primary" placeholder="Word to search">

                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary" onclick="wordSearch()">
                                        <i class="icon-search"></i> Search
                                    </button>
                                </span>
                            </div>
                        </form>

                            <hr>
                        <div class="searchResult" id="searchResult">
                            <div>
                                <h1 class="primary">Word</h1>
                                <p id="dictionaryResultWord"></p>
                            </div>
                            <hr>
                            <div>
                                <h1 class="primary">Definition</h1>
                                <p id="dictionaryResultDefinition"></p>
                            </div>
                            <hr>
                            <div>
                                <h1 class="primary">Example</h1>
                                <p id="dictionaryResultExample"></p>
                            </div>
                            <hr>
                            <div>
                                <h1 class="primary">Pronunciation?</h1>
                                <p id="dictionaryResultSpell"></p>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
