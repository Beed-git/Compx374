package com.google.ar.core.examples.java.helloar;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.CompoundButton;
import android.widget.ImageButton;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.google.ar.core.examples.java.webapi.WebApiThread;
import com.google.ar.core.examples.java.webapi.models.Competition;
import com.google.ar.core.examples.java.webapi.models.CompetitionRoot;
import com.google.ar.core.examples.java.webapi.models.Display;
import com.google.ar.core.examples.java.webapi.models.DisplayCollection;
import com.google.ar.core.examples.java.webapi.models.Media;
import com.google.ar.core.examples.java.webapi.models.MediaRoot;

import java.util.ArrayList;

public class HomeActivity extends AppCompatActivity {

    ToggleButton toggleLike, toggleDislike;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        ImageButton galleryButton = findViewById(R.id.imageButtonGallery);
        galleryButton.setEnabled(false);

        ToggleButton toggleLike = findViewById(R.id.toggleButtonVoteLike);
        ToggleButton toggleDislike = findViewById(R.id.toggleButtonVoteDislike);

        toggleLike.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    if (toggleDislike.isChecked()){
                        toggleDislike.setChecked(false);
                        //Decrement dislikes
                    }
                    //Increment likes
                } else {
                    //Decrement likes
                }
            }
        });

        toggleDislike.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {
                if (isChecked) {
                    if (toggleLike.isChecked()){
                        toggleLike.setChecked(false);
                        //Decrement likes
                    }
                    //Increment dislikes
                } else {
                    //Decrement dislikes
                }
            }
        });
    }

    public void mainDisplay(View v) {
        try {
            Intent intent = new Intent(this, HelloArActivity.class);
            Competition c = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/competitions/?location=anywhere", CompetitionRoot.class).get().competition;
            ArrayList<Display> displays = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/displays", DisplayCollection.class).get().displays;
            for (Display d : displays)
            {
                if (d.competitionId == c.id) {
                    Media m = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/media/?display_id=" + d.id, MediaRoot.class).get().media;
                    String url = "https://tuakiri.trex-sandwich.com/" + m.url.substring(3);
                    intent.putExtra("url", url);
                    startActivity(intent);
                    return;
                }
            }
            throw new Exception("Failed to find competition.");
        } catch (Exception ex) {
            ex.printStackTrace();
            Toast t = Toast.makeText(this, "Failed to find a display for the current competition.\n" + ex.toString(), Toast.LENGTH_LONG);
            t.show();
        }
    }

    public void searchButton(View v) {
        Intent intent = new Intent(this, SearchActivity.class);
        startActivity(intent);
    }

    public void galleryButton(View v) {
        Intent intent = new Intent(this, GalleryActivity.class);
        startActivity(intent);
    }

    public void settingsButton(View v) {
        Intent intent = new Intent(this, SearchActivity.class);
        startActivity(intent);
    }
}