package com.google.ar.core.examples.java.helloar;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.CompoundButton;
import android.widget.Toast;
import android.widget.ToggleButton;

public class HomeActivity extends AppCompatActivity {

    ToggleButton toggleLike, toggleDislike;
    @Override
    protected void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

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
        Intent intent = new Intent(this, HelloArActivity.class);
        startActivity(intent);
    }

    public void searchButton(View v) {
        Intent intent = new Intent(this, GalleryActivity.class);
        startActivity(intent);
    }

    public void galleryButton(View v) {
        Intent intent = new Intent(this, GalleryActivity.class);
        startActivity(intent);
    }

    public void settingsButton(View v) {
        Intent intent = new Intent(this, GalleryActivity.class);
        startActivity(intent);
    }
}