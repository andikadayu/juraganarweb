@extends('layouts.master')
@section('header','Setting')
@section('setting-active','active')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
                @endif
                <form action="{{ url()->current().'/process' }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Awal Nama Produk</label>
                                <textarea name="add_first_name" id="add_first_name" rows="5" style="height: 100px"
                                    class="form-control"><?= ($setting != null) ? $setting->add_first_name : null ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Akhir Nama Produk</label>
                                <textarea name="add_last_name" id="add_last_name" rows="5" style="height: 100px"
                                    class="form-control"><?= ($setting != null) ? $setting->add_last_name : null ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Awal Deskripsi</label>
                                <textarea name="add_first_description" id="add_first_description" rows="5"
                                    style="height: 100px"
                                    class="form-control"><?= ($setting != null) ? $setting->add_first_description : null ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Akhir Deskripsi</label>
                                <textarea name="add_last_description" id="add_last_description" rows="5"
                                    style="height: 100px"
                                    class="form-control"><?= ($setting != null) ? $setting->add_last_description : null ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Hapus Kata-Kata (Pemisah Enter ↩)</label>
                                <textarea name="remove_text" id="remove_text" rows="5" style="height: 100px"
                                    class="form-control"><?= ($setting != null) ? $setting->remove_text : null ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Preorder</label>
                                        <input type="number" name="preorder" id="preorder" class="form-control"
                                            value="<?= ($setting != null) ? $setting->preorder : null ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Etalase</label>
                                        <input type="number" name="etalase" id="etalase" class="form-control"
                                            value="<?= ($setting != null) ? $setting->etalase : null ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Kategori</label>
                                        <input type="number" name="kategori" id="kategori" class="form-control"
                                            value="<?= ($setting != null) ? $setting->kategori : null ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="">Markup</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="1"
                                                aria-label="Markup Checkbox" name="with_markup" id="with_markup"
                                                <?=($setting !=null) ? ($setting->with_markup) ? 'checked' : null :
                                            null
                                            ?>>
                                        </div>
                                        <input type="text" name="markup_value" id="markup_value" class="form-control"
                                            aria-label="Markup Text Input"
                                            value="<?= ($setting != null) ? $setting->markup_value : null ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="">Rumus</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-text">
                                            <input class="form-check-input mt-0" type="checkbox" value="1"
                                                aria-label="Checkbox for following text input" name="with_rumus"
                                                id="with_rumus" <?=($setting !=null) ? ($setting->with_rumus) ?
                                            'checked' : null : null ?>>
                                        </div>
                                        <select name="rumus_value" id="rumus_value" class="form-control">
                                            <option value="murah" <?=($setting !=null) ? ($setting->rumus_value ==
                                                'murah') ?
                                                'selected' : null : null ?>>Murah</option>
                                            <option value="sedang" <?=($setting !=null) ? ($setting->rumus_value ==
                                                'sedang') ?
                                                'selected' : null : null ?>>Sedang</option>
                                            <option value="mahal" <?=($setting !=null) ? ($setting->rumus_value ==
                                                'mahal') ?
                                                'selected' : null : null ?>>Mahal</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">berat</label>
                                        <input type="number" name="berat" id="berat" class="form-control"
                                            value="<?= ($setting != null) ? $setting->berat : null ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Min Pesan</label>
                                        <input type="number" name="min_pesan" id="min_pesan" class="form-control"
                                            value="<?= ($setting != null) ? $setting->min_pesan : null ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Min Stok</label>
                                        <input type="number" name="min_stok" id="min_stok" class="form-control"
                                            value="<?= ($setting != null) ? $setting->min_stok : null ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Min Harga</label>
                                        <input type="number" name="min_harga" id="min_harga" class="form-control"
                                            value="<?= ($setting != null) ? $setting->min_harga : null ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--//app-card-->
@endsection
@section('js')

@endsection