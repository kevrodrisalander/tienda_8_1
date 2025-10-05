<div class="col-md-4 mb-4">
    <div class="card card-categoria" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
        <img src="{{ asset($imagen) }}" alt="{{ $titulo }}"
             style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;
                    transition: transform 0.3s ease, opacity 0.3s ease; opacity: 0.85;"
             onmouseover="this.style.transform='scale(1.05)'; this.style.opacity='1'"
             onmouseout="this.style.transform='scale(1)'; this.style.opacity='0.85'">

        <div class="card-body">
            <h5 class="card-title">{{ $titulo }}</h5>
            <p class="card-text">{{ $descripcion }}</p>
            <a href="{{ $url }}" class="btn btn-primary">Ver más</a>
        </div>
    </div>
</div>
