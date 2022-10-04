package com.google.ar.core.examples.java.common.rendering;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;

import com.google.ar.core.examples.java.common.samplerender.SampleRender;

import java.io.IOException;
import java.nio.ByteBuffer;

public class ImageBuffer {
    private int width;
    private int height;
    private ByteBuffer buffer;

    public ImageBuffer(int width, int height, ByteBuffer buffer) {
        this.width = width;
        this.height = height;
        this.buffer = buffer;
    }

    public static ImageBuffer fromBitmap(SampleRender render, String assetFileName) throws IOException {
        // Load and convert the bitmap and copy its contents to a direct ByteBuffer. Despite its name,
        // the ARGB_8888 config is actually stored in RGBA order.
        Bitmap bitmap =
                convertBitmapToConfig(
                        BitmapFactory.decodeStream(render.getAssets().open(assetFileName)),
                        Bitmap.Config.ARGB_8888);
        return fromBitmap(bitmap);
    }

    public static ImageBuffer fromBitmap(Bitmap bitmap) {
        ByteBuffer buffer = ByteBuffer.allocateDirect(bitmap.getByteCount());
        bitmap.copyPixelsToBuffer(buffer);
        buffer.rewind();
        ImageBuffer imageBuffer = new ImageBuffer(bitmap.getWidth(), bitmap.getHeight(), buffer);
        bitmap.recycle();
        return imageBuffer;
    }

    public static Bitmap convertBitmapToConfig(Bitmap bitmap, Bitmap.Config config) {
        // We use this method instead of BitmapFactory.Options.outConfig to support a minimum of Android
        // API level 24.
        if (bitmap.getConfig() == config) {
            return bitmap;
        }
        Bitmap result = bitmap.copy(config, /*isMutable=*/ false);
        bitmap.recycle();
        return result;
    }

    public int getWidth() {
        return width;
    }

    public int getHeight() {
        return height;
    }

    public ByteBuffer getBuffer() {
        return buffer;
    }
}
