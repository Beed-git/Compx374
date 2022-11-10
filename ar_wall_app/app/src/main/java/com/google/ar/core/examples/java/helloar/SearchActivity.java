package com.google.ar.core.examples.java.helloar;

import android.content.Intent;
import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

import com.google.ar.core.examples.java.webapi.WebApiThread;
import com.google.ar.core.examples.java.webapi.models.Display;
import com.google.ar.core.examples.java.webapi.models.DisplayCollection;
import com.google.ar.core.examples.java.webapi.models.Media;
import com.google.ar.core.examples.java.webapi.models.MediaInstance;
import com.google.ar.core.examples.java.webapi.models.MediaRoot;

import org.w3c.dom.Text;

import java.util.ArrayList;


public class SearchActivity extends AppCompatActivity{

//    private String[] imageNames = {"https://image.shutterstock.com/image-illustration/huge-medieval-snake-glowing-green-600w-1638992110.jpg",
//            "https://www.belloflostsouls.net/wp-content/uploads/2021/12/icespire-header.jpg",
//            "https://image.shutterstock.com/image-illustration/red-dragon-blue-magic-swirling-260nw-1124418902.jpg",
//            "https://image.shutterstock.com/image-illustration/adventurer-came-across-golden-dragon-600w-1981678550.jpg",
//            "https://image.shutterstock.com/image-photo/dungeons-dragons-scene-made-miniatures-600w-1090759115.jpg"};
//            //"https://tuakiri.trex-sandwich.com/images/"};

    private ArrayList<String> textViewNames = new ArrayList<>();
    private ArrayList<String> imageNames = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_search);

        try{
            ArrayList<Display> displays = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/displays", DisplayCollection.class).get().displays;
            ArrayList<Media> media = new ArrayList<>();
            for (Display d : displays) {
                 Media m = WebApiThread.getInstance().get("https://tuakiri.trex-sandwich.com/api/media/?display_id=" + d.id, MediaRoot.class).get().media;
                 media.add(m);
            }

            // Ensure that there is one media for every display.
            if (media.size() == displays.size()) {
                int size = media.size();
                for (int i = 0; i < size; i++) {
                    Display d = displays.get(i);
                    if (d.name != null && !d.name.equals("")) {
                        textViewNames.add(d.name);
                        continue;
                    }
                    Media m = media.get(i);
                    if (m != null && m.name != null && !m.name.equals("")) {
                        textViewNames.add(m.name);
                        continue;
                    }
                    textViewNames.add("Display " + d.id);
                }

                for (int i = 0; i < size; i++) {
                    Media m = media.get(i);
                    String url = "https://tuakiri.trex-sandwich.com/" + m.url.substring(3);
                    System.out.println(url);
                    imageNames.add(url);
                }
            }
            else {
                System.out.println("Mismatch between number of displays and number of images");
                // TODO: fallback.
            }

            //Generating all views for number of images found on server (hard coded for now).
            for(int i = 0; i < textViewNames.size(); i+=2){
                //Getting parent
                LinearLayout parent = findViewById(R.id.parent);
                //Creating linear layouts
                LinearLayout verticalLayout1 = createLinearLayout(true, 1);
                LinearLayout verticalLayout2 = createLinearLayout(true, 1);
                LinearLayout horizontalLayout = createLinearLayout(false, 1);

                //Adding horizontal view
                parent.addView(horizontalLayout);

                //Checking if there are an odd number of images.
                if(i+1 == imageNames.size()){
                    ImageButton newImageButton1 = createImageButton(imageNames.get(i), i);
                    TextView newTextView1 = createTextView(textViewNames.get(i));
                    //Adding vertical views to horizontal views
                    horizontalLayout.addView(verticalLayout1);
                    horizontalLayout.addView(verticalLayout2);

                    //Adding Image View and Text view
                    verticalLayout1.addView(newImageButton1);
                    verticalLayout1.addView(newTextView1);
                }
                else
                {
                    ImageButton newImageButton1 = createImageButton(imageNames.get(i), i);
                    ImageButton newImageButton2 = createImageButton(imageNames.get(i+1), i+1);

                    TextView newTextView1 = createTextView(textViewNames.get(i));
                    TextView newTextView2 = createTextView(textViewNames.get(i+1));

                    //Adding vertical views to horizontal views
                    horizontalLayout.addView(verticalLayout1);
                    horizontalLayout.addView(verticalLayout2);

                    //Adding Image View and Text view
                    verticalLayout1.addView(newImageButton1);
                    verticalLayout1.addView(newTextView1);
                    verticalLayout2.addView(newImageButton2);
                    verticalLayout2.addView(newTextView2);
                }
            }
        }
        catch (Exception e)
        {
            e.printStackTrace();
        }
    }

    //Creating a Text View
    protected TextView createTextView(String text){
        TextView newTextView = new TextView(this);
        newTextView.setText(text);

        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.WRAP_CONTENT);

        newTextView.setLayoutParams(params);
        return newTextView;
    }

    //Creating a linear layout
    protected LinearLayout createLinearLayout(boolean vertical, int weight){
        LinearLayout newLayout = new LinearLayout(this);
        //Adding params

        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                LinearLayout.LayoutParams.MATCH_PARENT,
                LinearLayout.LayoutParams.MATCH_PARENT,
                1.0f);

        newLayout.setLayoutParams(params);

        //Checking if wanting a vertical layout
        if(vertical) {
            newLayout.setOrientation(LinearLayout.VERTICAL);
            newLayout.setPadding(10, 0, 10, 5);
        }
        else {
            newLayout.setOrientation(LinearLayout.HORIZONTAL);
        }
        return newLayout;
    }

    //Creates a new image button
    protected ImageButton createImageButton(String url, int id){
        //Creating button
        ImageButton newImageButton = new ImageButton(this);
        newImageButton.setId(id);
        try{
            //Adding params
            LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(
                    LinearLayout.LayoutParams.MATCH_PARENT,
                    LinearLayout.LayoutParams.WRAP_CONTENT);

            newImageButton.setLayoutParams(params);

            //Adding url
            newImageButton.setImageBitmap(WebApiThread.getInstance().getImageFromURL(url).get());
        }
        catch (Exception e){
            e.printStackTrace();
        }

        newImageButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                System.out.println("THIS IS THE ID"+ v.getId());
                startAR(v.getId());
            }
        });
        //Returning the imageButton
        return newImageButton;
    }


    public void startAR(int id){
        Intent intent = new Intent(this, HelloArActivity.class);
        intent.putExtra("ID", id);
        intent.putExtra("url", imageNames.get(id));
        startActivity(intent);
    }

    //Fetch images from server "http...."
    //Assign an image to each imagebutton
    //onButtonClick get image id

}
