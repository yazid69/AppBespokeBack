<?php

namespace App\Http\Controllers;

use App\Mail\InscriptionCreateurMail;
use App\Models\Createur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CreateurController extends Controller
{
    public function createCreateur(Request $request)
    {
        // créer un createur
        $createurDonnee = $request->validate([
            "genre" => ["required", "string", "max:10"], // "Monsieur" ou "Madame
            "nom" => ["required", "string", "max:30"],
            "prenom" => ["required", "string", "max:30"],
            "dateNaissance" => ["required", "date"],
            "email" => ["required", "string", "email", "max:40", "unique:createurs"],
            "mdpCreateur" => ["required", "string", "min:8", "max:30"],
            "telCreateur" => ["required", "string", "max:20"],
            "numRue" => ["nullable", "string", "max:10"],
            "rue" => ["nullable", "string", "max:50"],
            "codePostal" => ["nullable", "integer", "min:5"],
            "ville" => ["nullable", "string", "max:30"],
            "pays" => ["nullable", "string", "max:30"],
            "debutActivite" => ["nullable", "date"],
            "siret" => ["required", "integer", "min:14"],
        ]);
        // hasher le mot de passe
        $createurDonnee["mdpCreateur"] = Hash::make($createurDonnee["mdpCreateur"]);
        // enregistrer le createur dans la base de données
        $createur = Createur::create($createurDonnee);
        // retourner la réponse quand le createur est créé

        Mail::to($createurDonnee["email"])->send(new InscriptionCreateurMail($createurDonnee));

        return response()->json([
            "createur" => $createur,
            "message" => "Createur créé avec succès",
            "status" => 201,
        ]);
    }

    public function getCreateurById($idCreateur)
    {
        // récupérer le createur par son id
        $createur = Createur::find($idCreateur);
        // verifier si le createur existe
        if (!$createur) {
            return response()->json([
                "message" => "Createur non trouvé",
            ], 404);
        }
        // ne renvoyer que le nom, prénom et email du createur
        $createur = [
            'genre' => $createur->genre,
            'nom' => $createur->nom,
            'prenom' => $createur->prenom,
            'email' => $createur->email,
        ];
        // retourner la réponse avec le createur
        return response()->json([
            "createur" => $createur,
            "message" => "Createur récupéré avec succès",
            "status" => 200,
        ]);
    }

    public function getCreateurs()
    {
        // récupérer tous les createurs
        $createurs = Createur::all();
        // ne renvoyer que le prénom et la date de naissance de chaque createur
        $createurs = $createurs->map(function ($createur) {
            return [
                'genre' => $createur->genre,
                'nom' => $createur->nom,
                'prenom' => $createur->prenom,
                'email' => $createur->email,
            ];
        });
        // retourner la réponse
        return response()->json([
            "createurs" => $createurs,
            "status" => 200,
        ]);
    }

    public function loginCreateur(Request $request)
    {
        // verifier les données du créateur
        $createurDonnee = $request->validate([
            "email" => ["required", "string", "email", "max:40"],
            "mdpCreateur" => ["required", "string", "min:8", "max:30"],
        ]);
        // vérifier si le createur existe avec le bon mot de passe
        $createur = Createur::where("email", $createurDonnee["email"])->first();
        if (!$createur || !Hash::check($createurDonnee["mdpCreateur"], $createur->mdpCreateur)) {
            return response()->json([
                "message" => "Email ou mot de passe incorrect",
            ], 401);
        }
        // créer le token
        $tokenResult = $createur->createToken('authToken');
        $token = $tokenResult->plainTextToken;
        // retourner la réponse avec le token
        return response()->json([
            "createur" => $createur,
            "access_token" => $token,
            "message" => "Connexion réussie",
            "status" => 200,
        ]);
    }

    public function updateCreateur(Request $request, Createur $createur)
    {
        // récupérer les données actuelles du createur
        $currentDonnee = $createur->toArray();

        // vérifier les données envoyées par le createur
        $createurDonnee = $request->validate([
            "nom" => ["required", "string", "max:30"],
            "prenom" => ["required", "string", "max:30"],
            "dateNaissance" => ["required", "date"],
            "email" => ["required", "string", "email", "max:40", Rule::unique('createurs')->ignore($createur->id)],
            "mdpCreateur" => ["required", "string", "min:8", "max:30"],
            "telCreateur" => ["required", "string", "max:20"],
            "numRue" => ["required", "string", "max:10"],
            "rue" => ["required", "string", "max:50"],
            "codePostal" => ["required", "integer", "min:5"],
            "ville" => ["required", "string", "max:30"],
            "pays" => ["required", "string", "max:30"],
            "debutActivite" => ["required", "date"],
            "siret" => ["required", "integer", "min:14"],
        ]);

        // recuperer l'id du createur dans l'url
        $idCreateur = $request->route("idCreateur");
        $createurDonnee["idCreateur"] = intval($idCreateur);

        if (isset($createurDonnee["mdpCreateur"])) {
            // hasher le mot de passe
            $createurDonnee["mdpCreateur"] = Hash::make($createurDonnee["mdpCreateur"]);
        }

        // fusionner les données validées avec les données actuelles
        $updatedData = array_merge($currentDonnee, array_filter($createurDonnee));

        // mettre à jour les données de le createur
        $result = DB::table('createurs')
            ->where('idCreateur', $createurDonnee['idCreateur'])
            ->update([
                'nom' => $updatedData['nom'],
                'prenom' => $updatedData['prenom'],
                'dateNaissance' => $updatedData['dateNaissance'],
                'email' => $updatedData['email'],
                'mdpCreateur' => $updatedData['mdpCreateur'],
                'telCreateur' => $updatedData['telCreateur'],
                'numRue' => $updatedData['numRue'],
                'rue' => $updatedData['rue'],
                'codePostal' => $updatedData['codePostal'],
                'ville' => $updatedData['ville'],
                'pays' => $updatedData['pays'],
                'debutActivite' => $updatedData['debutActivite'],
                'siret' => $updatedData['siret'],
            ]);

        // retourner la réponse quand le createur est mis à jour
        if ($result) {
            return response()->json([
                "createur" => $updatedData,
                "message" => "createur mis à jour avec succès",
            ]);
        } else {
            return response()->json([
                "message" => "Erreur lors de la mise à jour du createur",
                "status" => 500,
            ]);
        }
    }

    public function deleteCreateur(Request $request, $idCreateur)
    {
        // valider le mot de passe de l'utilisateur
        $request->validate([
            'mdpCreateur' => ['required', 'string', 'min:8', 'max:30'],
        ]);

        // récupérer l'id de l'utilisateur
        $createur = Createur::findorFail($idCreateur);

        // vérifier si le mot de passe est correct
        if (!Hash::check($request->mdpCreateur, $createur->mdpCreateur)) {
            return response()->json([
                "message" => "Mot de passe incorrect",
                "status" => 401,
            ]);
        }

        // retirer le token associé à l'utilisateur dans la base de données
        $createur->tokens()->delete();

        // supprimer l'utilisateur
        $createur->delete();
        // retourner la réponse
        return response()->json([
            "message" => "Utilisateur supprimé avec succès",
            "status" => 200,
        ]);
    }
}
