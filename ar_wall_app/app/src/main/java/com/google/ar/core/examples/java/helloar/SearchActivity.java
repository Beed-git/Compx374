package com.google.ar.core.examples.java.helloar;

import android.os.Bundle;
import android.widget.ImageButton;
import android.widget.LinearLayout;

import androidx.appcompat.app.AppCompatActivity;

import com.google.ar.core.examples.java.webapi.WebApiThread;


public class SearchActivity extends AppCompatActivity{

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //System.out.println(("Hi Brad"));
        setContentView(R.layout.activity_search);



        try{
            //String[] imageNames = {"https://tuakiri.trex-sandwich.com/images/login-background.jpg", "https://tuakiri.trex-sandwich.com/images/example-mural.jpg"};
            String[] imageNames = {"https://image.shutterstock.com/image-illustration/huge-medieval-snake-glowing-green-600w-1638992110.jpg",
                     "https://www.belloflostsouls.net/wp-content/uploads/2021/12/icespire-header.jpg"};
            ImageButton imageButton;

            LinearLayout container =  findViewById(R.id.first2images);
            LinearLayout firstLayout = (LinearLayout) container.getChildAt(0);
            LinearLayout secondLayout = (LinearLayout) container.getChildAt(1);

            int[] imageButtonIds = {firstLayout.getChildAt(0).getId(), secondLayout.getChildAt(0).getId()};

            //imageButton = findViewById(R.id.imageButton1);
            //imageButton.setImageBitmap(WebApiThread.getInstance().getImageFromURL("https://tuakiri.trex-sandwich.com/images/login-background.jpg").get());
            for(int i = 0; i<2; i++){

                imageButton = findViewById(imageButtonIds[i]);
                imageButton.setImageBitmap(WebApiThread.getInstance().getImageFromURL(imageNames[i]).get());
            }

        }
        catch (Exception e)
        {
            e.printStackTrace();
        }
        //imageButton.setImageDrawable();
    }

    //Fetch images from server "http...."
    //Assign an image to each imagebutton
    //onButtonClick get image id

}
