<div class="row">
    <h2 class="center-align"><b>經濟新聞</b></h2>
    <div class="row">
        @foreach($newsData['articles'] as $article)
            <div class="col m4">
                <div class="card">
                    <div class="card-image">
                        <img src="{{ $article['urlToImage'] }}" alt="News Image">
                    </div>
                    <div class="card-content">
                        <b><h5>{{ $article['title'] }}</h5></b>
                        <p>{{ $article['description'] }}</p>
                    </div>
                    <div class="card-action">
                        <a href="{{ $article['url'] }}" target="_blank">閱讀原文</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>