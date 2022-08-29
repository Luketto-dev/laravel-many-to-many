<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Post;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{

    // ritorna un elemento cercato per il suo slug
    private function findBySlug($slug){

        $post = Post::where("slug", $slug)->first();

        if (!$post) {
            abort(404);
        }

        return $post;
    }

    private function generateSlug($text){
        $toReturn = null;
        $counter = 0;
        do {
            // generiamo uno slug partendo dal titolo
            $slug = Str::slug($text);

            // se il counter è maggiore di zero, concateno il suo valore allo slug
            if ($counter > 0 ) {
                $slug .= "-" . $counter;
            }

            // controllo a db se esistye gia uno slug uguale
            $slug_exist = Post::where("slug", $slug)->first();
            
            if ($slug_exist) {
                // se esiste, incremento il contatore pert il ciclo successivo
                $counter ++;
            }else{
                // altrimenti salvo lo slug nei dati del nuovo post
                $toReturn = $slug;
            }
        } while ($slug_exist);

        return $toReturn;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = Auth::user();
        if ($user->role === "admin") {
            $posts = Post::orderBy("created_at", "desc")->get();
        }else{
            $posts = $user->posts;
        }

        return view("admin.posts.index", compact("posts"));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.create", compact("categories", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validare i dati ricevuti
        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "nullable|exists:tags,id"
        ]);

        // salvare a db i dati
        $post = new Post();

        $post-> fill($validatedData);

        $post->user_id = Auth::user()->id;

        $post->slug = $this->generateSlug($post->title);

        $post->save();

        // nel caso dello store prima di associare i tag devo salvare il post creato in modo da
        // permettere al db di generare un ID per il post, questo id è essenziale per fare l associazione nella tab ponte
        if (key_exists("tags", $validatedData)) {
            $post->tags()->attach($validatedData['tags']);
        }
        

        //redirect su una pagina desiderata, di solito show
        return redirect()-> route("admin.posts.show", $post->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $post = $this->findBySlug($slug);

        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = $this->findBySlug($slug);
        $categories = Category::all();
        $tags = Tag::all();

        return view("admin.posts.edit", compact("post", "categories", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        // validare i dati ricevuti
        $validatedData = $request->validate([
            "title" => "required|min:10",
            "content" => "required|min:10",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "nullable|exists:tags,id",
            "cover_img" => "nullable|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);


        $post = $this->findBySlug($slug);

        // cover img non esisterà sempre quindi lo salvo solo se ho la chiave presente nell array dei dati validati
        // controlliamo se il file è stato inviato dall utente
        if (key_exists("cover_img", $validatedData)) {
            
            if ($post->cover_img) {
                Storage::delete($post->cover_img);
            }

            $cover_img = Storage::put("/post_covers", $validatedData["cover_img"]);

            $post->cover_img = $cover_img;
        }

        if ($validatedData["title"] !== $post->title) {
            //genero nuovo slug
            $post->slug = $this->generateSlug($validatedData["title"]);
        }

        //toglie dalla tab ponte tutte le relazioni dei $post
        $post->tags()->detach();

        //se l utente mi invia deio tag, devo associarli al post corrente
        //se non mi invia i tag, devo rimuovere tutte le associazioni asistenti per il post corrente

        if (key_exists("tags", $validatedData)) {

            //salvo l associazione di questo post con i tag che gli vado a passare
            $post->tags()->attach($validatedData['tags']);
            //$post->tags()->sync($validatedData['tags']);

        }
        
        $post->update($validatedData);

        return redirect()->route("admin.posts.show", $post->slug);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $post = $this->findBySlug($slug);

        $post->delete();

        return redirect()->route("admin.posts.index");
    }
}
