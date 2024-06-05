<!-- resources/views/partials/_carousel.blade.php -->
<section class="pt-5 pb-5">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <h3 class="carousel-title mb-3">{{ $carouselTitle }}</h3>
          </div>
          <div class="col-12">
              <div id="carouselExampleIndicators{{ $carouselId }}" class="carousel slide" data-interval="false">
                  <div class="carousel-inner">
                      @foreach ($films->chunk(4) as $chunk)
                          <div class="carousel-item @if($loop->first) active @endif">
                              <div class="row">
                                  @foreach ($chunk as $film)
                                      <div class="col-md-3 mb-3">
                                          <div class="card h-100">
                                              <img class="img-fluid" src="{{ $film->thumbnail }}" alt="{{ $film->title }}" style="width: 100%; height: 300px; object-fit: cover;">
                                              <div class="card-body">
                                                  <h5 class="card-title">{{ $film->title }}</h5>
                                                  <p class="card-text">Durée: {{ $film->length }}</p>
                                                  <p class="card-text">Réalisateur: {{ $film->director->name }}</p>
                                                  <p class="card-text">
                                                      Tags: 
                                                      @foreach ($film->tags as $tag)
                                                          <span class="badge badge-primary">{{ $tag->name }}</span>
                                                      @endforeach
                                                  </p>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>
          <div class="col-12 text-center">
              <a class="btn btn-primary mb-3 mr-1" href="#carouselExampleIndicators{{ $carouselId }}" role="button" data-slide="prev">
                  <i class="fa fa-arrow-left"></i>
              </a>
              <a class="btn btn-primary mb-3" href="#carouselExampleIndicators{{ $carouselId }}" role="button" data-slide="next">
                  <i class="fa fa-arrow-right"></i>
              </a>
          </div>
      </div>
  </div>
</section>

<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
<script type="text/javascript" src="https://stackpath.amazonaws.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
      $('#carouselExampleIndicators{{ $carouselId }}').carousel({
          interval: false
      });
  });
</script>

<style>
  .carousel-title {
      color: #ffffff; /* Changez cette valeur pour la couleur souhaitée */
  }
  .card {
      background-color: #fffbe8; /* Changez cette valeur pour la couleur de fond souhaitée */
  }
  .card-title {
      font-size: 1.1rem;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
  }
  .card-text {
      font-size: 0.9rem;
  }
  .badge-primary {
      background-color: #3d1987;
      font-size: 0.8rem;
      margin-right: 2px;
  }
</style>
